<?php

namespace App\Controller\Portal;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\EmailClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/portal/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'controller_name'=>'Usuarios',
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new( Request $request, UserRepository $userRepository,UserPasswordEncoderInterface $encoder, EmailClass $emailClass): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['action'=>$this->generateUrl('app_user_new'),'method'=>'POST']);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() ) {
            
            $encoded = $encoder->encodePassword($user, "nueva123");
            if($request->get('clientes')){
                $user->setRoles(['ROLE_ACCOUNT']);
            }else{
                $user->setRoles(['ROLE_USER']);
            }
            $user->setPassword($encoded);
            $userRepository->add($user, true);
            
            
            $em->persist($user);
            $em->flush();
            // $bodyHtml = $this->getBodyHtml($user,$form->get('password')->getData());
            // $bodyAlt = $this->getBodyAlt($user);
            // $emailClass->sendMail(Array([
            //     'mail'=>$user->getEmail(),
            //     'name'=>$user->getFullName()
            // ]), '', 'Bienvenid@', $bodyHtml, $bodyAlt);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }



    /**
     * @Route("/edit/{id}", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user, ['action'=>$this->generateUrl('app_user_edit', Array('id'=>$user->getId())),'method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getBodyHtml(User $usuario,$password){
        return '<div>
            <h6>Bienvenid@ '.$usuario->getFullName().'!</h6>
            <p>Te damos la bienvenida a la plataforma digital para administrar la gestión de transferencias de Maquinaras.</p>
            <p>Tus datos de acceso son:</p>
            <ul>
                <li>Usuario: <b>'.$usuario->getEmail().'</b></li>
                <li>Password: <b>'.$password.'</b></li>
            </ul>
        </div>';
    }
    private function getBodyAlt(User $usuario,$password){
        return 'Bienvenid@ '.$usuario->getFullName().'!\r\n
            Te damos la bienvenida a la plataforma digital para administrar la gestión de transferencias de Maquinaras.\r\n
            Tus datos de acceso son:\r\n
                Usuario: '.$usuario->getEmail().'\r\n
                Password: '.$password.'\r\n
            ';
    }

    /**
     * @Route("/read-messages/", name="app_user_read_messages", methods={ "POST"})
     */
    public function readMessages(Request $request): Response
    {
        $em  = $this->getDoctrine()->getManager();

        $usuario = $this->getUser();
        $comentarios = $usuario->getReceivedComments();
        foreach ($comentarios as $comentario) {
            $comentario->addReadBy($usuario);
            $em->persist($comentario);
        }
        $em->flush();
        return new Response();
    }
    
}
