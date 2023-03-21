<?php

namespace App\Controller;

use App\Entity\Cuenta;
use App\Controller\BaseController;
use App\Form\CuentaType;
use App\Repository\CuentaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/cuenta")
 */
class CuentaController extends BaseController
{
    /**
     * @Route("/", name="app_cuenta_index", methods={"GET"})
     */
    public function index(CuentaRepository $cuentaRepository): Response
    {
        return $this->render('cuenta/index.html.twig', [
            'cuentas' => $cuentaRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_cuenta_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CuentaRepository $cuentaRepository): Response
    {
        $cuentum = new Cuenta();
        $form = $this->createForm(CuentaType::class, $cuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuentaRepository->add($cuentum, true);

            return $this->redirectToRoute('app_cuenta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuenta/new.html.twig', [
            'cuentum' => $cuentum,
            'form' => $form,
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}", name="app_cuenta_show", methods={"GET"})
     */
    public function show(Cuenta $cuentum): Response
    {
        return $this->render('cuenta/show.html.twig', [
            'cuentum' => $cuentum,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_cuenta_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cuenta $cuentum, CuentaRepository $cuentaRepository): Response
    {
        $form = $this->createForm(CuentaType::class, $cuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuentaRepository->add($cuentum, true);

            return $this->redirectToRoute('app_cuenta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuenta/edit.html.twig', [
            'cuentum' => $cuentum,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cuenta_delete", methods={"POST"})
     */
    public function delete(Request $request, Cuenta $cuentum, CuentaRepository $cuentaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cuentum->getId(), $request->request->get('_token'))) {
            $cuentaRepository->remove($cuentum, true);
        }

        return $this->redirectToRoute('app_cuenta_index', [], Response::HTTP_SEE_OTHER);
    }
}
