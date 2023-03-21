<?php

namespace App\Controller;

use App\Entity\AccountingGroup2;
use App\Controller\BaseController;
use App\Form\AccountingGroup2Type;
use App\Repository\AccountingGroup2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portal/accounting/group2")
 */
class AccountingGroup2Controller extends BaseController
{
    /**
     * @Route("/", name="app_accounting_group2_index", methods={"GET"})
     */
    public function index(AccountingGroup2Repository $accountingGroup2Repository): Response
    {
        return $this->render('accounting_group2/index.html.twig', [
            'accounting_group2s' => $accountingGroup2Repository->findAll(),
            'documentos'=>$this->documents,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/new", name="app_accounting_group2_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AccountingGroup2Repository $accountingGroup2Repository): Response
    {
        $accountingGroup2 = new AccountingGroup2();
        $form = $this->createForm(AccountingGroup2Type::class, $accountingGroup2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountingGroup2Repository->add($accountingGroup2, true);

            return $this->redirectToRoute('app_accounting_group2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting_group2/new.html.twig', [
            'accounting_group2' => $accountingGroup2,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accounting_group2_show", methods={"GET"})
     */
    public function show(AccountingGroup2 $accountingGroup2): Response
    {
        return $this->render('accounting_group2/show.html.twig', [
            'accounting_group2' => $accountingGroup2,
            'clientes'=>$this->clientes
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_accounting_group2_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AccountingGroup2 $accountingGroup2, AccountingGroup2Repository $accountingGroup2Repository): Response
    {
        $form = $this->createForm(AccountingGroup2Type::class, $accountingGroup2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountingGroup2Repository->add($accountingGroup2, true);

            return $this->redirectToRoute('app_accounting_group2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting_group2/edit.html.twig', [
            'accounting_group2' => $accountingGroup2,
            'form' => $form,
            'clientes'=>$this->clientes,
            'documentos'=>$this->documents,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accounting_group2_delete", methods={"POST"})
     */
    public function delete(Request $request, AccountingGroup2 $accountingGroup2, AccountingGroup2Repository $accountingGroup2Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accountingGroup2->getId(), $request->request->get('_token'))) {
            $accountingGroup2Repository->remove($accountingGroup2, true);
        }

        return $this->redirectToRoute('app_accounting_group2_index', [], Response::HTTP_SEE_OTHER);
    }
}
