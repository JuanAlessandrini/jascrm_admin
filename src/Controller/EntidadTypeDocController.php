<?php

namespace App\Controller;

use App\Entity\EntidadTypeDoc;
use App\Controller\BaseController;
use App\Form\EntidadTypeDocType;
use App\Repository\EntidadTypeDocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/entidad-type-doc")
 */
class EntidadTypeDocController extends BaseController
{
    /**
     * @Route("/", name="app_entidad_type_doc_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('entidad_type_doc/index.html.twig', [
            'entidad_type_docs' => $this->documents,
            'documentos' => $this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_entidad_type_doc_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntidadTypeDocRepository $entidadTypeDocRepository): Response
    {
        $entidadTypeDoc = new EntidadTypeDoc();
        $form = $this->createForm(EntidadTypeDocType::class, $entidadTypeDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entidadTypeDocRepository->add($entidadTypeDoc, true);

            return $this->redirectToRoute('app_entidad_type_doc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entidad_type_doc/new.html.twig', [
            'entidad_type_doc' => $entidadTypeDoc,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entidad_type_doc_show", methods={"GET"})
     */
    public function show(EntidadTypeDoc $entidadTypeDoc): Response
    {
        return $this->render('entidad_type_doc/show.html.twig', [
            'entidad_type_doc' => $entidadTypeDoc,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_entidad_type_doc_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntidadTypeDoc $entidadTypeDoc, EntidadTypeDocRepository $entidadTypeDocRepository): Response
    {
        $form = $this->createForm(EntidadTypeDocType::class, $entidadTypeDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entidadTypeDocRepository->add($entidadTypeDoc, true);

            return $this->redirectToRoute('app_entidad_type_doc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entidad_type_doc/edit.html.twig', [
            'entidad_type_doc' => $entidadTypeDoc,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entidad_type_doc_delete", methods={"POST"})
     */
    public function delete(Request $request, EntidadTypeDoc $entidadTypeDoc, EntidadTypeDocRepository $entidadTypeDocRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entidadTypeDoc->getId(), $request->request->get('_token'))) {
            $entidadTypeDocRepository->remove($entidadTypeDoc, true);
        }

        return $this->redirectToRoute('app_entidad_type_doc_index', [], Response::HTTP_SEE_OTHER);
    }
}
