<?php

namespace App\Controller;

use App\Entity\CuentaAuxiliar;
use App\Form\CuentaAuxiliarType;
use App\Controller\BaseController;
use App\Repository\CuentaAuxiliarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/cuenta-auxiliar")
 */
class CuentaAuxiliarController extends BaseController
{
    /**
     * @Route("/", name="app_cuenta_auxiliar_index", methods={"GET"})
     */
    public function index(CuentaAuxiliarRepository $cuentaAuxiliarRepository): Response
    {
        return $this->render('cuenta_auxiliar/index.html.twig', [
            'cuenta_auxiliars' => $cuentaAuxiliarRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_cuenta_auxiliar_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CuentaAuxiliarRepository $cuentaAuxiliarRepository): Response
    {
        $cuentaAuxiliar = new CuentaAuxiliar();
        $form = $this->createForm(CuentaAuxiliarType::class, $cuentaAuxiliar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuentaAuxiliarRepository->add($cuentaAuxiliar, true);

            return $this->redirectToRoute('app_cuenta_auxiliar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuenta_auxiliar/new.html.twig', [
            'cuenta_auxiliar' => $cuentaAuxiliar,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cuenta_auxiliar_show", methods={"GET"})
     */
    public function show(CuentaAuxiliar $cuentaAuxiliar): Response
    {
        return $this->render('cuenta_auxiliar/show.html.twig', [
            'cuenta_auxiliar' => $cuentaAuxiliar,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_cuenta_auxiliar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CuentaAuxiliar $cuentaAuxiliar, CuentaAuxiliarRepository $cuentaAuxiliarRepository): Response
    {
        $form = $this->createForm(CuentaAuxiliarType::class, $cuentaAuxiliar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuentaAuxiliarRepository->add($cuentaAuxiliar, true);

            return $this->redirectToRoute('app_cuenta_auxiliar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuenta_auxiliar/edit.html.twig', [
            'cuenta_auxiliar' => $cuentaAuxiliar,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cuenta_auxiliar_delete", methods={"POST"})
     */
    public function delete(Request $request, CuentaAuxiliar $cuentaAuxiliar, CuentaAuxiliarRepository $cuentaAuxiliarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cuentaAuxiliar->getId(), $request->request->get('_token'))) {
            $cuentaAuxiliarRepository->remove($cuentaAuxiliar, true);
        }

        return $this->redirectToRoute('app_cuenta_auxiliar_index', [], Response::HTTP_SEE_OTHER);
    }
}
