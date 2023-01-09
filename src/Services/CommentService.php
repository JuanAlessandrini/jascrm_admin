<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tramite;
use App\Entity\TramiteItem;
use App\Entity\Comment;
use App\Entity\TipoTramite;
use App\Entity\Documento;
use App\Entity\User;
use App\Repository\DocumentoRepository;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentService
{
   
    private $em;
    private $serializer;
    private $userRepo;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        $this->em = $em;
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return Array('id'=> $object->getId());
            },
        ];
        $normalizer = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $this->serializer = new Serializer([new DateTimeNormalizer(Array('d.m.Y')),$normalizer]);   
        $this->userRepo = $userRepo;
    }
    public function addUserComment( $tramite,$comment,$user){
            return $this->addComment( $tramite,$user->getFullName(), $comment, '/img/faces/avatar-default-icon.png', 'user',$user);
    }

    public function addCommentNewTramite(Tramite $tramite, User $user){
        return $this->addComment( $tramite, "Creación",$user->getFirstName() ." ". $user->getLastName() . " creó el trámite", 'create_new_folder', 'icon', $user);
    }

    public function addCommentNewUpload(Tramite $tramite, User $user,Documento $document){
        return $this->addComment( $tramite, "Nuevo Upload",$user->getFirstName() ." ". $user->getLastName() . " subió un nuevo documento: ".$document->getName(), 'description', 'icon', $user);
    }

    public function addCommentItem($tramite, $user, $comment,$tramiteItem){
        return $this->addComment($tramite,$user->getFullName(), $comment,'/img/faces/avatar-default-icon.png', 'user',$user, $tramiteItem);
    }

    
    public function addCommentAutorizacion($tramite, $user, $comment){
        return $this->addComment($tramite,$user->getFullName().' autorizo la entrega.', $comment,'/img/faces/avatar-default-icon.png', 'user',$user, null);
    }

    public function addCommentChangeStatus(Tramite $tramite, User $user, $status){
        return $this->addComment( $tramite, $status, $user->getFirstName() ." ". $user->getLastName() . " modificó el estado del trámite #ID".$tramite->getId(), 'change_circle', 'icon', $user);
    }

    public function addCommentChangeItemStatus(Tramite $tramite, TramiteItem $item,User $user, $status){
        return $this->addComment( $tramite, $status, $user->getFirstName() ." ". $user->getLastName() . " modificó el estado del item ".$item->getDocumento()->getName(), 'change_circle', 'icon', $user);
    }

    public function addComment(Tramite $tramite,$title, $commentText, $icon, $type_icon,User $user, TramiteItem $item = null)
    {
        try {
            $comment = new Comment();
            $comment->setComment($commentText);
            $comment->setUser($user);
            $comment->setTramite($tramite);
            $comment->setTypeIcon($type_icon);
            $comment->setIcon($icon);
            $comment->setTitle($title);
            $comment->setCreatedAt(new \DateTime('now'));
            if($item!== null){
                $comment->setTramiteItem($item);
            }
            $this->sendNotifications($tramite, $comment, $user);
            $this->em->persist($comment);
            $this->em->flush();
            
            return true;
        } catch (\Throwable $th) {
            throw new \Exception("Error al crear comentario:".$th->getMessage(), 1);
            
        }
        
    }
    
    private function sendNotifications (Tramite $tramite,Comment $comment,User $sender){
        try {
            //code...
        
            $receivers = $this->getReceivers($tramite, $sender);
            foreach ($receivers as $receiver) {
                $comment->addSentTo($receiver);
            }
        } catch (\Exception $th) {
            throw new \Exception("Error al enviar Notificacion:".$th->getMessage(), 1);
        }
    }

    private function getReceivers (Tramite $tramite,User $sender){
        $receivers = [];
        foreach ($tramite->getConcesionaria()->getUsers() as $receiver) {
            if($receiver !== $sender){
                array_push($receivers, $receiver);
            }
        }
        $gestores = $this->userRepo->findByRole('ROLE_GESTORIA');
        foreach ($gestores as $receiver) {
            // if($receiver !== $sender){
                array_push($receivers, $receiver);
            // }
        }
        return $receivers;
    }
    
}
