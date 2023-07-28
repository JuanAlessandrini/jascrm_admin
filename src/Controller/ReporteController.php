<?php

namespace App\Controller;

use App\Entity\Reporte;
use App\Form\ReporteType;
use App\Repository\ReporteRepository;
use App\Repository\DocumentRepository;
use App\Repository\GranoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reporte")
 */
class ReporteController extends BaseController
{
    /**
     * @Route("/", name="app_reporte_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('reporte/index.html.twig', [
            'reportes' => $this->reportes,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }


    
    /**
     * @Route("/view/{id}", name="app_reporte_view", methods={"GET", "POST"})
     */
    public function view(Reporte $reporte, Request $request,GranoRepository $granoRepository, DocumentRepository $documentoRepository): Response
    {
        $customer = $this->getUser()->getDefaultCliente();
        $documentos = $documentoRepository->getBaseReport($request, $reporte, $customer);
        if(in_array($reporte->getId(), [ 1, 2])){
            $ccostos = explode(',', $customer->getCentroCostos()) ;
            $td = $this->getDinamicTableByCentroCosto($documentos, $ccostos);
        }else{
            $td = $this->getDinamicTable($documentos, $reporte);
        }
        
        return $this->render('reporte/'.$reporte->getTemplate().'.html.twig', [
            'reportes' => $this->reportes,
            'clientes'=>$this->clientes,
            'reporte'=>$reporte,
            'campanias'=>$this->getCampanias(),
            'granos'=>$granoRepository->findAll(),
            'documentos'=>$this->documents,
            'listaDocumentos'=>$documentos,
            'filters'=>$request->request->All(),
            'total'=>sizeOf($documentos),
            'customer'=>$customer,
            'td'=>$td
        ]);
    }

    /**
     * @Route("/new", name="app_reporte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReporteRepository $reporteRepository): Response
    {
        $reporte = new Reporte();
        $form = $this->createForm(ReporteType::class, $reporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reporteRepository->add($reporte, true);

            return $this->redirectToRoute('app_reporte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reporte/new.html.twig', [
            'reporte' => $reporte,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }


    /**
     * @Route("/{id}", name="app_reporte_show", methods={"GET"})
     */
    public function show(Reporte $reporte): Response
    {
        return $this->render('reporte/show.html.twig', [
            'reporte' => $reporte,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reporte_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reporte $reporte, ReporteRepository $reporteRepository): Response
    {
        $form = $this->createForm(ReporteType::class, $reporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reporteRepository->add($reporte, true);

            return $this->redirectToRoute('app_reporte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reporte/edit.html.twig', [
            'reporte' => $reporte,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reporte_delete", methods={"POST"})
     */
    public function delete(Request $request, Reporte $reporte, ReporteRepository $reporteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reporte->getId(), $request->request->get('_token'))) {
            $reporteRepository->remove($reporte, true);
        }

        return $this->redirectToRoute('app_reporte_index', [], Response::HTTP_SEE_OTHER);
    }

    public function getDinamicTableByCentroCosto($listaDocumentos, $ccostos){
        $conceptos = [];
        $cantidades = [];
        $promedios = [];
        $totales = [];
        $respuesta = [];
        
        foreach ($ccostos as $concepto) {
            $detail = $this->getDinamicTableDetailByCentroCosto($listaDocumentos, $concepto);
            
            // array_push($conceptos,Array('id'=>$concepto->getId(),'concepto'=>));
            // array_push($cantidades, $detail['cantidad']);
            // array_push($promedios,$detail['promedio']);
            // array_push($totales, $detail['total']);

            
                array_push($respuesta, Array(
                    'concepto'=>$concepto,
                    'cantidad'=>$detail['cantidad'],
                    'promedio'=>$detail['promedio'],
                    'itemCant'=>$detail['itemCant'],
                    'total'=>$detail['total'],
                ));
            
            
        }
        return $respuesta;
    }

    public function getDinamicTable($listaDocumentos, $reporte){
        $conceptos = [];
        $cantidades = [];
        $promedios = [];
        $totales = [];
        $respuesta = [];
        
        foreach ($reporte->getConceptos() as $concepto) {
            $detail = $this->getDinamicTableDetail($listaDocumentos, $concepto->getId());
            
            // array_push($conceptos,Array('id'=>$concepto->getId(),'concepto'=>));
            // array_push($cantidades, $detail['cantidad']);
            // array_push($promedios,$detail['promedio']);
            // array_push($totales, $detail['total']);

            
                array_push($respuesta, Array(
                    'concepto'=>$concepto->getName(),
                    'cantidad'=>$detail['cantidad'],
                    'promedio'=>$detail['promedio'],
                    'itemCant'=>$detail['itemCant'],
                    'total'=>$detail['total'],
                ));
            
            
        }
        return $respuesta;
    }
    public function getDinamicTableDetail($listaDocumentos, $conceptoId){
        $cantidad = 0;
        $promedio = 0;
        $total = 0;
        $i =0;
        foreach ($listaDocumentos as $documento) {
            $signo = $documento->getTipo()->getSigno();
            foreach ($documento->getDetail() as $detail) {
                if($detail->getConcepto()->getId() == $conceptoId){
                    $cantidad += (@$detail->getCantidad() * ($signo));
                    $total += @$detail->getAmmount() * ($signo);
                    $i++;
                }
                
            }
            
        }
        $promedio = ($total /( $cantidad == 0 ? 1 : $cantidad));

        return [
            'cantidad'=>$cantidad,
            'promedio'=>$promedio,
            'itemCant'=>$i,
            'total'=>$total,
        ];
    }

    private function getDinamicTableDetailByCentroCosto($listaDocumentos, $concepto){
        $cantidad = 0;
        $promedio = 0;
        $total = 0;
        $i =0;
        foreach ($listaDocumentos as $documento) {
            $signo = $documento->getTipo()->getSigno();
            if($documento->getCentroCosto() == $concepto){
                foreach ($documento->getDetail() as $detail){
                    $cantidad += (@$detail->getCantidad() * ($signo));
                    $total += @$detail->getAmmount() * ($signo);
                }
                $i++;
            }
        }
        $promedio = ($total /( $cantidad == 0 ? 1 : $cantidad));

        return [
            'cantidad'=>$cantidad,
            'promedio'=>$promedio,
            'itemCant'=>$i,
            'total'=>$total,
        ];
    }
}
