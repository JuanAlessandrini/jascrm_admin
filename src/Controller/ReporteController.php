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
        $td = $this->getDinamicTable($documentos, $reporte);
        return $this->render('reporte/'.$reporte->getTemplate().'.html.twig', [
            'reportes' => $this->reportes,
            'clientes'=>$this->clientes,
            'reporte'=>$reporte,
            'campanias'=>$this->getCampanias(),
            'granos'=>$granoRepository->findAll(),
            'documentos'=>$this->documents,
            'listaDocumentos'=>$documentos,
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

    public function getDinamicTable($listaDocumentos, $reporte){
        $conceptos = [];
        $cantidades = [];
        $promedios = [];
        $totales = [];
        $respuesta = [];

        foreach ($reporte->getConceptos() as $concepto) {
            $detail = $this->getDinamicTableDetail($listaDocumentos, $concepto->getId());
            array_push($conceptos,Array('id'=>$concepto->getId(),'concepto'=>$concepto->getName()));
            array_push($cantidades, $detail['cantidad']);
            array_push($promedios,$detail['promedio']);
            array_push($totales, $detail['total']);

            foreach ($conceptos as $key=>$value) {
                array_push($respuesta, Array(
                    'concepto'=>$value,
                    'cantidad'=>$cantidades[$key],
                    'promedio'=>$promedios[$key],
                    'total'=>$totales[$key],
                ));
            }
            return $respuesta;
        }

    }
    public function getDinamicTableDetail($listaDocumentos, $conceptoId){
        $cantidad = 0;
        $promedio = 0;
        $total = 0;
        foreach ($listaDocumentos as $documento) {
            foreach ($documento->getDetail() as $detail) {
                if($detail->getConcepto()->getId() == $conceptoId){
                    $cantidad += $detail->getCantidad();
                    $total += $detail->getAmmount();
                }
            }
        }
        $promedio = ($total /( $cantidad == 0 ? 1 : $cantidad));

        return [
            'cantidad'=>$cantidad,
            'promedio'=>$promedio,
            'total'=>$total,
        ];
    }
}
