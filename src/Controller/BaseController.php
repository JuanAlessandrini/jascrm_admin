<?php

namespace App\Controller;

use App\Repository\EntidadTypeDocRepository;
use App\Repository\CustomerRepository;
use App\Repository\ReporteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BaseController extends AbstractController
{
  
    public $documents;
    public $clientes;
    public $reportes;

  public function __construct(EntidadTypeDocRepository $doc,  CustomerRepository $clientes,ReporteRepository $reportes )
  {
    $this->documents = $doc->findAll();
    $this->clientes = $clientes->findAll();
    $this->reportes = $reportes->findAll();
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
