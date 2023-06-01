<?php

namespace App\Controller;

use App\Repository\EntidadTypeDocRepository;
use App\Repository\CustomerRepository;
use App\Repository\ReporteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends AbstractController
{
  
    public $documents;
    public $clientes;
    public $reportes;
    /**
     * @var Security
     */
    private $security;
    private $emInterface;

  public function __construct(EntidadTypeDocRepository $doc,  CustomerRepository $clientes,ReporteRepository $reportes, Security $security, EntityManagerInterface $emInterface)
  {
    
    $this->emInterface = $emInterface;
    $this->documents = $doc->findAll();
    
    $this->reportes = $reportes->findAll();
    $this->security = $security;
    $user = $this->security->getUser();

    $this->clientes =  sizeof($user->getClientes()) > 0 ? $user->getClientes() : $clientes->findAll();

    if(!$user->getDefaultCliente()){
        $user->setDefaultCliente($this->clientes[0]);
        
        $this->emInterface->persist($user);
        $this->emInterface->flush();
    }

  }
    
  public function getCampanias(){
    $camp = [];
    $anio =  (int) date('Y');
    $retro = -3;
    for ($i=0; $i < 5; $i++) { 
        
        array_push($camp, ($anio + $i + $retro));
    }
    return $camp;
}
}
