<?php

namespace App\Controller;

use App\Entity\Grano;
use App\Form\GranoType;
use App\Repository\GranoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grano")
 */
class GranoController extends BaseController
{
    /**
     * @Route("/", name="app_grano_index", methods={"GET"})
     */
    public function index(GranoRepository $granoRepository): Response
    {
        return $this->render('grano/index.html.twig', [
            'controller_name'=>'Granos',
            'granos' => $granoRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_grano_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GranoRepository $granoRepository): Response
    {
        $grano = new Grano();
        $form = $this->createForm(GranoType::class, $grano,['action'=>$this->generateUrl('app_grano_new'),'method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $granoRepository->add($grano, true);

            return $this->redirectToRoute('app_grano_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grano/new.html.twig', [
            'grano' => $grano,
            'form' => $form,
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

   

    /**
     * @Route("/edit/{id}", name="app_grano_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Grano $grano, GranoRepository $granoRepository): Response
    {
        $form = $this->createForm(GranoType::class, $grano,[
            'action'=>$this->generateUrl('app_grano_edit',['id'=>$grano->getId()])
            ,'method'=>'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $granoRepository->add($grano, true);

            return $this->redirectToRoute('app_grano_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grano/edit.html.twig', [
            'grano' => $grano,
            'form' => $form,
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}", name="app_grano_delete", methods={"POST"})
     */
    public function delete(Request $request, Grano $grano, GranoRepository $granoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grano->getId(), $request->request->get('_token'))) {
            $granoRepository->remove($grano, true);
        }

        return $this->redirectToRoute('app_grano_index', [], Response::HTTP_SEE_OTHER);
    }
}
