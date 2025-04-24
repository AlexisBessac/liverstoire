<?php

namespace App\Controller\Admin;

use App\Entity\Periods;
use App\Form\PeriodsType;
use App\Repository\PeriodsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/periods')]
final class PeriodsController extends AbstractController
{
    #[Route(name: 'app_admin_periods_index', methods: ['GET'])]
    public function index(PeriodsRepository $periodsRepository): Response
    {
        return $this->render('admin/periods/index.html.twig', [
            'periods' => $periodsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_periods_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $period = new Periods();
        $form = $this->createForm(PeriodsType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($period);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_periods_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/periods/new.html.twig', [
            'period' => $period,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_periods_show', methods: ['GET'])]
    public function show(Periods $period): Response
    {
        return $this->render('admin/periods/show.html.twig', [
            'period' => $period,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_periods_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Periods $period, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PeriodsType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_periods_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/periods/edit.html.twig', [
            'period' => $period,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_periods_delete', methods: ['POST'])]
    public function delete(Request $request, Periods $period, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$period->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($period);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_periods_index', [], Response::HTTP_SEE_OTHER);
    }
}
