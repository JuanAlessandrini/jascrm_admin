<?php

namespace App\Controller;

use App\Entity\EntidadField;
use App\Form\EntidadFieldType;
use App\Controller\BaseController;
use App\Repository\EntidadFieldRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/entidad-field")
 */
class EntidadFieldController extends BaseController
{
    /**
     * @Route("/", name="app_entidad_field_index", methods={"GET"})
     */
    public function index(EntidadFieldRepository $entidadFieldRepository): Response
    {
        return $this->render('entidad_field/index.html.twig', [
            'entidad_fields' => $entidadFieldRepository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_entidad_field_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntidadFieldRepository $entidadFieldRepository): Response
    {
        $entidadField = new EntidadField();
        $form = $this->createForm(EntidadFieldType::class, $entidadField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entidadFieldRepository->add($entidadField, true);

            return $this->redirectToRoute('app_entidad_field_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entidad_field/new.html.twig', [
            'entidad_field' => $entidadField,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_entidad_field_show", methods={"GET"})
     */
    public function show(EntidadField $entidadField): Response
    {
        return $this->render('entidad_field/show.html.twig', [
            'entidad_field' => $entidadField,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_entidad_field_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntidadField $entidadField, EntidadFieldRepository $entidadFieldRepository): Response
    {
        $form = $this->createForm(EntidadFieldType::class, $entidadField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entidadFieldRepository->add($entidadField, true);

            return $this->redirectToRoute('app_entidad_field_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entidad_field/edit.html.twig', [
            'entidad_field' => $entidadField,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entidad_field_delete", methods={"POST"})
     */
    public function delete(Request $request, EntidadField $entidadField, EntidadFieldRepository $entidadFieldRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entidadField->getId(), $request->request->get('_token'))) {
            $entidadFieldRepository->remove($entidadField, true);
        }

        return $this->redirectToRoute('app_entidad_field_index', [], Response::HTTP_SEE_OTHER);
    }
}
