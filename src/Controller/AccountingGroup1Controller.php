<?php

namespace App\Controller;

use App\Entity\AccountingGroup1;
use App\Controller\BaseController;
use App\Form\AccountingGroup1Type;
use App\Repository\AccountingGroup1Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/accounting/group1")
 */
class AccountingGroup1Controller extends BaseController
{
    /**
     * @Route("/", name="app_accounting_group1_index", methods={"GET"})
     */
    public function index(AccountingGroup1Repository $accountingGroup1Repository): Response
    {
        return $this->render('accounting_group1/index.html.twig', [
            'accounting_group1s' => $accountingGroup1Repository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_accounting_group1_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AccountingGroup1Repository $accountingGroup1Repository): Response
    {
        $accountingGroup1 = new AccountingGroup1();
        $form = $this->createForm(AccountingGroup1Type::class, $accountingGroup1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountingGroup1Repository->add($accountingGroup1, true);

            return $this->redirectToRoute('app_accounting_group1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting_group1/new.html.twig', [
            'accounting_group1' => $accountingGroup1,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accounting_group1_show", methods={"GET"})
     */
    public function show(AccountingGroup1 $accountingGroup1): Response
    {
        return $this->render('accounting_group1/show.html.twig', [
            'accounting_group1' => $accountingGroup1,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_accounting_group1_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AccountingGroup1 $accountingGroup1, AccountingGroup1Repository $accountingGroup1Repository): Response
    {
        $form = $this->createForm(AccountingGroup1Type::class, $accountingGroup1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountingGroup1Repository->add($accountingGroup1, true);

            return $this->redirectToRoute('app_accounting_group1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting_group1/edit.html.twig', [
            'accounting_group1' => $accountingGroup1,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accounting_group1_delete", methods={"POST"})
     */
    public function delete(Request $request, AccountingGroup1 $accountingGroup1, AccountingGroup1Repository $accountingGroup1Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accountingGroup1->getId(), $request->request->get('_token'))) {
            $accountingGroup1Repository->remove($accountingGroup1, true);
        }

        return $this->redirectToRoute('app_accounting_group1_index', [], Response::HTTP_SEE_OTHER);
    }
}
