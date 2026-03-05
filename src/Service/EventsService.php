<?php

namespace App\Service;

use App\Entity\Events;
use App\Exception\PersistenceException;
use App\Exception\ResourceNotFoundException;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class EventsService
{
    public function __construct(
        private EventsRepository $eventsRepository,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Récupère tous les événements
     * 
     * @return Events[]
     */
    public function getAll(): array
    {
        return $this->eventsRepository->findAll();
    }

    /**
     * Récupère tous les événements triés
     * 
     * @return Events[]
     */
    public function getAllOrdered(): array
    {
        return $this->eventsRepository->findAllOrdered();
    }

    /**
     * Récupère un événement par son ID
     * 
     * @throws ResourceNotFoundException si l'événement n'existe pas
     */
    public function getById(int $id): Events
    {
        $event = $this->eventsRepository->find($id);

        if (!$event) {
            $this->logger->warning(sprintf('Tentative d\'accès à un événement inexistant : ID %d', $id));
            throw new ResourceNotFoundException('Événement', $id);
        }

        return $event;
    }

    /**
     * Crée un nouvel événement
     * 
     * @throws PersistenceException en cas d'erreur lors de la sauvegarde
     */
    public function create(Events $event): Events
    {
        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->logger->info('Nouvel événement créé avec succès');
            return $event;
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création d\'un événement', ['exception' => $e]);
            throw new PersistenceException('Impossible de créer l\'événement', $e);
        }
    }

    /**
     * Met à jour un événement
     * 
     * @throws PersistenceException en cas d'erreur lors de la sauvegarde
     */
    public function update(Events $event): Events
    {
        try {
            $this->entityManager->flush();
            $this->logger->info(sprintf('Événement ID %d mis à jour avec succès', $event->getId()));
            return $event;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Erreur lors de la mise à jour de l\'événement ID %d', $event->getId()), ['exception' => $e]);
            throw new PersistenceException('Impossible de mettre à jour l\'événement', $e);
        }
    }

    /**
     * Supprime un événement
     * 
     * @throws PersistenceException en cas d'erreur lors de la suppression
     */
    public function delete(Events $event): void
    {
        try {
            $this->entityManager->remove($event);
            $this->entityManager->flush();
            $this->logger->info(sprintf('Événement ID %d supprimé avec succès', $event->getId()));
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Erreur lors de la suppression de l\'événement ID %d', $event->getId()), ['exception' => $e]);
            throw new PersistenceException('Impossible de supprimer l\'événement', $e);
        }
    }

    /**
     * Recherche les événements par titre ou date
     * 
     * @return Events[]
     */
    public function search(string $searchTerm): array
    {
        return $this->eventsRepository->searchByTitleOrDate($searchTerm);
    }
}
