<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use App\Controller\Services\EmailClass;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function show(FlattenException $exception, Request $request): Response
    {
        
        if(in_array($exception->getStatusCode(), [404]) || !$request->isXmlHttpRequest()){
            return $this->render('error/index.html.twig', [
                'controller_name' => 'ErrorController',
                'message'=>$exception->getMessage(),
                'file'=>$exception->getFile(),
                'line'=>$exception->getLine(),
                'code'=>$exception->getStatusCode(),
                'statusText'=>$exception->getStatusText()

            ]);
        }else{
            // $exception->getStatusCode().' '.
            return new Response($exception->getMessage());
        }
        
            
        
        
    }
}
