<?php

namespace App\Service;

use App\Entity\Periods;
use App\Exception\PersistenceException;
use App\Exception\ResourceNotFoundException;
use App\Repository\PeriodsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PeriodsService
{
    public function __construct(
        private PeriodsRepository $periodsRepository,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Récupère toutes les périodes
     * 
     * @return Periods[]
     */
    public function getAll(): array
    {
        return $this->periodsRepository->findAll();
    }

    /**
     * Récupère une période par son ID
     * 
     * @throws ResourceNotFoundException si la période n'existe pas
     */
    public function getById(int $id): Periods
    {
        $period = $this->periodsRepository->find($id);
        
        if (!$period) {
            $this->logger->warning(sprintf('Tentative d\'accès à une période inexistante : ID %d', $id));
            throw new ResourceNotFoundException('Période', $id);
        }
        
        return $period;
    }

    /**
     * Crée une nouvelle période
     * 
     * @throws PersistenceException en cas d'erreur lors de la sauvegarde
     */
    public function create(Periods $period): Periods
    {
        try {
            $this->entityManager->persist($period);
            $this->entityManager->flush();
            $this->logger->info('Nouvelle période créée avec succès');
            return $period;
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création d\'une période', ['exception' => $e]);
            throw new PersistenceException('Impossible de créer la période', $e);
        }
    }

    /**
     * Met à jour une période
     * 
     * @throws PersistenceException en cas d'erreur lors de la sauvegarde
     */
    public function update(Periods $period): Periods
    {
        try {
            $this->entityManager->flush();
            $this->logger->info(sprintf('Période ID %d mise à jour avec succès', $period->getId()));
            return $period;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Erreur lors de la mise à jour de la période ID %d', $period->getId()), ['exception' => $e]);
            throw new PersistenceException('Impossible de mettre à jour la période', $e);
        }
    }

    /**
     * Supprime une période
     * 
     * @throws PersistenceException en cas d'erreur lors de la suppression
     */
    public function delete(Periods $period): void
    {
        try {
            $this->entityManager->remove($period);
            $this->entityManager->flush();
            $this->logger->info(sprintf('Période ID %d supprimée avec succès', $period->getId()));
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Erreur lors de la suppression de la période ID %d', $period->getId()), ['exception' => $e]);
            throw new PersistenceException('Impossible de supprimer la période', $e);
        }
    }
}
