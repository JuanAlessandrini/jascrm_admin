<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Controller\BaseController;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/customer")
 */
class CustomerController extends BaseController
{
    /**
     * @Route("/", name="app_customer_index", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customer/index.html.twig', [
            'customers' => $customerRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_customer_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CustomerRepository $customerRepository): Response
    {

        
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer,['action'=>$this->generateUrl('app_customer_new'),'method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customerRepository->add($customer, true);

            return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/new.html.twig', [
            'controller_name'=>'Nuevo Cliente',
            'customer' => $customer,
            'form' => $form,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_customer_show", methods={"GET"})
     */
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
            'clientes'=>$this->clientes
        ]);
    }

     /**
     * @Route("/change-client", name="app_customer_change", methods={"POST"})
     */
    public function changeClient(Request $request, CustomerRepository $customerRepo): Response
    {
        $em = $this->getDoctrine()->getManager();
       $cliente = $customerRepo->findOneById($request->get('value'));
       $usuario = $this->getUser();
       $usuario->setDefaultCliente($cliente);
        $em->persist($usuario);
        $em->flush();
        return new Response(true);
    }


    /**
     * @Route("/edit/{id}", name="app_customer_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        $form = $this->createForm(CustomerType::class, $customer,['action'=>$this->generateUrl('app_customer_edit', Array('id'=>$customer->getId())),'method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $customerRepository->add($customer, true);

            return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_customer_delete", methods={"POST"})
     */
    public function delete(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $customerRepository->remove($customer, true);
        }

        return $this->redirectToRoute('app_customer_index', [], Response::HTTP_SEE_OTHER);
    }
}
