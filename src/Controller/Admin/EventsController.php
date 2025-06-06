<?php

namespace App\Controller\Admin;

use App\Entity\Events;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/events')]
final class EventsController extends AbstractController
{
    #[Route(name: 'app_admin_events_index', methods: ['GET'])]
    public function index(Request $request, EventsRepository $eventsRepository): Response
    {
        $search = $request->query->get('search', '');

        $events = !empty($search) ? $eventsRepository->searchByTitleOrDate($search) : $eventsRepository->findAllOrdered();

        return $this->render('admin/events/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/new', name: 'app_admin_events_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/events/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_events_show', methods: ['GET'])]
    public function show(Events $event): Response
    {
        return $this->render('admin/events/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_events_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/events/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_events_delete', methods: ['POST'])]
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_events_index', [], Response::HTTP_SEE_OTHER);
    }
}
