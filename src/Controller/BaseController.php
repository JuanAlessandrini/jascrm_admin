<?php

namespace App\Controller;

use App\Repository\EntidadTypeDocRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BaseController extends AbstractController
{
  
    public $documents;
    public $clientes;

  public function __construct(EntidadTypeDocRepository $doc,  CustomerRepository $clientes)
  {
    $this->documents = $doc->findAll();
    $this->clientes = $clientes->findAll();
  }
    
    
}
