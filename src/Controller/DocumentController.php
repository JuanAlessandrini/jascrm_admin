<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\EntidadTypeDoc;
use App\Form\DocumentType;
use App\Controller\BaseController;
use App\Repository\DocumentRepository;
use App\Repository\GranoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/document")
 */
class DocumentController extends BaseController
{
    /**
     * @Route("/view/{typeEnt}", name="app_document_index", methods={"GET", "POST"})
     */
    public function index(Request $request, DocumentRepository $documentRepository,GranoRepository $granoRepository, EntidadTypeDoc $typeEnt): Response
    {
        if ($this->getUser()->getDefaultCliente()==null){
            throw new \Exception("Debes seleccionar un cliente", 1);
            
        }

        if($request->isMethod("POST")){
            $documentos = $documentRepository->aplicaFiltros($request, $this->getUser()->getDefaultCliente(), $typeEnt);
        }else{
            $documentos = $documentRepository->findBy(Array(
                'customer'=>$this->getUser()->getDefaultCliente(),
                'tipo'=>$typeEnt
            ), Array('created_at'=>'DESC'));
            
        }

        return $this->render('document/index.html.twig', [
            'clientes'=>$this->clientes,
            'documents' => $documentos,
            'documentos'=>$this->documents,
            'reportes'=>$this->reportes,
            'entidadTypeDoc'=> $typeEnt,
            'controller_name'=>$typeEnt->getName(),
            'campanias'=>$this->getCampanias(),
            'granos'=>$granoRepository->findAll(),
            'customer'=>$this->getUser()->getDefaultCliente()
        ]);
    }

    /**
     * @Route("/new/{typeEnt}", name="app_document_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntidadTypeDoc $typeEnt, DocumentRepository $documentRepository): Response
    {
        if ($this->getUser()->getDefaultCliente()==null){
            throw new \Exception("Debes seleccionar un cliente", 1);
        }

        $document = new Document();
        $document->setCustomer($this->getUser()->getDefaultCliente());
        $document->setEntidad($typeEnt->getEntidad());
        $document->setTipo($typeEnt);
        $document->setModifiedAt(new \DateTime('now'));
        $document->setCreatedBy($this->getUser());
        $document->setModifiedBy($this->getUser());
        $document->setCustomer($this->getUser()->getDefaultCliente());
        $form = $this->createForm(DocumentType::class, $document,[
                'tipo'=>($typeEnt->getEntidad()->getName()=='Ventas' ? 'Ingreso' : 'Egreso') ,
                'action'=>$this->generateUrl('app_document_new', Array('typeEnt'=>$typeEnt->getId())),'method'=>'POST']);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if(array_key_exists('sucursal', $request->get("document"))){
                $document->setSucursal($request->get("document")['sucursal']);
            }
            if(array_key_exists('centro_costo', $request->get("document"))){
                $document->setCentroCosto($request->get("document")['centro_costo']);
            }
            if(array_key_exists('codigo', $request->get("document"))){
                $document->setCodigo($request->get("document")['codigo']);
            }
            $document->setTotal($request->get("document")['total']);
            $documentRepository->add($document, true);

            return $this->redirectToRoute('app_document_index', ['typeEnt'=>$document->getTipo()->getId()], Response::HTTP_SEE_OTHER);
        }else{
            
        }

        return $this->renderForm('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_document_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Document $document, DocumentRepository $documentRepository): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentRepository->add($document, true);

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_document_delete", methods={"POST"})
     */
    public function delete(Request $request, Document $document, DocumentRepository $documentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $documentRepository->remove($document, true);
        }

        return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
