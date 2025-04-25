<?php

namespace App\Controller;

use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Events;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EventsRepository $eventsRepository): Response
    {
        $events = $eventsRepository->findBy([], ['chronos' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/book/{id}', name: 'app_events_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Events $bevents): Response
    {
        // Vérifie si le livre existe
        if (!$bevents) {
            throw $this->createNotFoundException("Il n'existe pas de description de cet évéènement");
        }

        return $this->render('home/show.html.twig', [
            'events' => $bevents,
        ]);
    }
}
