<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TipoTramite;
use App\Entity\Documento;
use App\Repository\DocumentoRepository;
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

class TipoTramiteService
{
   
    private $em;
    private $serializer;

    public function __construct(EntityManagerInterface $em)
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
    }

   
    // public function getCursosAVencer($desde, $hasta)
    // {
    //     $respuesta = [];
    //     // $empresas = $this->em->getRepository(Enterprise::class)->findAll();
    //     $empresas = $this->em->createQuery('SELECT cur FROM App\Entity\CursadaAlumnos cur WHERE cur.vigencia >= :desde AND cur.vigencia <= :hasta')
    //     ->setParameter('desde', $desde)
    //     ->setParameter('hasta', $hasta)
    //     ->getResult();

    //     $arr_empresas = $this->serializer->normalize($empresas, null, ['groups' => 'vencidos',AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);
    //     return ($arr_empresas);
    // }

    public function getDocumentosTipoTramite(TipoTramite $tramite = null, bool $getAllDocuments = true)
    {
        $arr_docs = [];
        
        // $empresas = $this->em->getRepository(Enterprise::class)->findAll();
        if($tramite){
            $result = $this->em->getConnection()->prepare('SELECT doc.id, doc.name, doc.request_image, doc.request_paper, doc.role_upload, doc.oculto, docu.tipo_tramite_id as id_tramite
            FROM documento doc 
            '.($getAllDocuments ? ' LEFT JOIN' : 'INNER JOIN').' (SELECT * FROM tipo_tramite_documento WHERE tipo_tramite_id = '.$tramite->getId().') docu 
            ON doc.id = docu.documento_id')
            ->execute()->fetchAll();      
            
        }else{
            $result = $this->em->createQuery('SELECT doc.id, doc.name, doc.request_image, doc.request_paper, doc.role_upload, 0 as id_tramite, doc.oculto FROM App\Entity\Documento doc ')
            ->getResult();
        }

        foreach ($result as $value) {
            $fechas_manuales = [];
            $result_fecha = $this->em->createQuery('SELECT fecha.id, fecha.name FROM App\Entity\Documento doc JOIN doc.fecha_manual fecha WHERE doc.id = '.$value['id'])
            ->getResult();
            foreach ($result_fecha as $fecha_manual) {
                array_push($fechas_manuales, Array('id'=>$fecha_manual['id'],'name'=>$fecha_manual['name']));
            }
            //TODO: AGREGAR Fechas Manuales al array
            array_push($arr_docs, Array('id'=>$value['id'], 'name'=>$value['name'], 'request_image'=>$value['request_image'], 'request_paper'=>$value['request_paper'], 'checked'=>($value['id_tramite'] > 0 ? 1 : 0),  'role_upload'=>$value['role_upload'],  'oculto'=>$value['oculto'], 'fechas_manuales'=>$fechas_manuales));
        }
        
        return ($arr_docs);
    }
    
    
    
}
