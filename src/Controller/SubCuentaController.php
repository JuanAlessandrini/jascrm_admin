<?php

namespace App\Controller;

use App\Entity\SubCuenta;
use App\Form\SubCuentaType;
use App\Controller\BaseController;
use App\Repository\SubCuentaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/sub-cuenta")
 */
class SubCuentaController extends BaseController
{
    /**
     * @Route("/", name="app_sub_cuenta_index", methods={"GET"})
     */
    public function index(SubCuentaRepository $subCuentaRepository): Response
    {
        return $this->render('sub_cuenta/index.html.twig', [
            'sub_cuentas' => $subCuentaRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_sub_cuenta_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SubCuentaRepository $subCuentaRepository): Response
    {
        $subCuentum = new SubCuenta();
        $form = $this->createForm(SubCuentaType::class, $subCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCuentaRepository->add($subCuentum, true);

            return $this->redirectToRoute('app_sub_cuenta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_cuenta/new.html.twig', [
            'sub_cuentum' => $subCuentum,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sub_cuenta_show", methods={"GET"})
     */
    public function show(SubCuenta $subCuentum): Response
    {
        return $this->render('sub_cuenta/show.html.twig', [
            'sub_cuentum' => $subCuentum,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_sub_cuenta_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SubCuenta $subCuentum, SubCuentaRepository $subCuentaRepository): Response
    {
        $form = $this->createForm(SubCuentaType::class, $subCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCuentaRepository->add($subCuentum, true);

            return $this->redirectToRoute('app_sub_cuenta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_cuenta/edit.html.twig', [
            'sub_cuentum' => $subCuentum,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sub_cuenta_delete", methods={"POST"})
     */
    public function delete(Request $request, SubCuenta $subCuentum, SubCuentaRepository $subCuentaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCuentum->getId(), $request->request->get('_token'))) {
            $subCuentaRepository->remove($subCuentum, true);
        }

        return $this->redirectToRoute('app_sub_cuenta_index', [], Response::HTTP_SEE_OTHER);
    }
}
