<?php

namespace App\Controller\Portal;
use App\Controller\BaseController;
use App\Repository\EntidadTypeDocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;



/**
 * @Route("/portal/dashboard")
 */
class DashboardController extends BaseController
{
    /**
     * @Route("/", name="app_dashboard")
     */
    public function index(): Response
    {
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'HomeController',
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes,
        ]);
    }

    
    
}
