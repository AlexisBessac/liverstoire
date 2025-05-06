<?php

namespace App\Controller;

use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Events;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EventsRepository $eventsRepository): Response
    {
        // Récupère le numéro de page depuis la requête (par défaut : 1)
        $page = $request->query->getInt('page', 1);
        $limit = 10; // Nombre d'éléments par page

        // Utilise la méthode du repository pour paginer
        $events = $eventsRepository->paginateEvents($page, $limit);

        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/{title}', name: 'app_events_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Events $events): Response
    {
        // Vérifie si l'évènement existe
        if (!$events) {
            throw $this->createNotFoundException("Il n'existe pas de description de cet évéènement");
        }

        return $this->render('home/show.html.twig', [
            'events' => $events,
        ]);
    }
}