<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Curso;
use App\Entity\Enterprise;
use App\Repository\CursoRepository;
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

class CursoService
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

   
    public function getCursosAVencer($desde, $hasta)
    {
        $respuesta = [];
        // $empresas = $this->em->getRepository(Enterprise::class)->findAll();
        $empresas = $this->em->createQuery('SELECT cur FROM App\Entity\CursadaAlumnos cur WHERE cur.vigencia >= :desde AND cur.vigencia <= :hasta')
        ->setParameter('desde', $desde)
        ->setParameter('hasta', $hasta)
        ->getResult();

        $arr_empresas = $this->serializer->normalize($empresas, null, ['groups' => 'vencidos',AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);
        return ($arr_empresas);
    }

    
    
    
}
