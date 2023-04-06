<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Form\VendorType;
use App\Controller\BaseController;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/proveedores")
 */
class VendorController extends BaseController
{
    /**
     * @Route("/", name="app_vendor_index", methods={"GET"})
     */
    public function index(VendorRepository $vendorRepository): Response
    {
        return $this->render('vendor/index.html.twig', [
            'controller_name'=>'Clientes',
            'vendors' => $vendorRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes,
            'reportes'=>$this->reportes,
        ]);
    }

    /**
     * @Route("/new", name="app_vendor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VendorRepository $vendorRepository): Response
    {
        $vendor = new Vendor();
        $form = $this->createForm(VendorType::class, $vendor,['action'=>$this->generateUrl('app_vendor_new'),'method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorRepository->add($vendor, true);

            return $this->redirectToRoute('app_vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor/new.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_vendor_show", methods={"GET"})
     */
    public function show(Vendor $vendor): Response
    {
        return $this->render('vendor/show.html.twig', [
            'vendor' => $vendor,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_vendor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendorRepository->add($vendor, true);

            return $this->redirectToRoute('app_vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendor/edit.html.twig', [
            'vendor' => $vendor,
            'form' => $form,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_vendor_delete", methods={"POST"})
     */
    public function delete(Request $request, Vendor $vendor, VendorRepository $vendorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendor->getId(), $request->request->get('_token'))) {
            $vendorRepository->remove($vendor, true);
        }

        return $this->redirectToRoute('app_vendor_index', [], Response::HTTP_SEE_OTHER);
    }
}
