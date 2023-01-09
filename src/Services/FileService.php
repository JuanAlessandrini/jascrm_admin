<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
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
use Symfony\Component\Config\Definition\Exception\Exception;

class FileService
{
   
   

    public function __construct()
    {
    }

    public function upload( $file, $name){
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $file;
                    
        $public_folder="/uploads/signatures";
        if (in_array($uploadedFile->guessExtension(), ['png','pdf', 'jpg', 'svg', 'gif', 'jpeg'])) {
            $destination = $_SERVER['DOCUMENT_ROOT'] . $public_folder;
            $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            // preg_replace('/\s+/', '',
            $newFileName = preg_replace('/\s+/', '',rand(1,700000).$name. '.' . $uploadedFile->guessExtension());
            $uploadedFile->move($destination, $newFileName);
            return $public_folder.'/'.$newFileName;
        } else{
            throw new Exception("La imagen no pudo subirse", 1);
        }
    }

    public function createFromDataUri( $content, $public_folder, $name){
        
        
        
        $img = str_replace('data:image/png;base64,', '',$content);
        $encoded_image = str_replace(' ', '+', $img);
        $decoded_image = base64_decode($encoded_image);
        $destination = $_SERVER['DOCUMENT_ROOT'] . $public_folder;
        $newFileName = preg_replace('/\s+/', '',rand(1,700000).$name. '.png');

        file_put_contents($destination.$newFileName, $decoded_image);

        return $public_folder.$newFileName;
        
    }

    
    
    
}

