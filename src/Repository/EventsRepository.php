<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Events>
 */
class EventsRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Events::class);
        $this->paginator = $paginator;
    }

    //    /**
    //     * @return Events[] Returns an array of Events objects
    //     */
    public function paginateEvents(int $page, int $limit)
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('e'),
            $page,
            $limit
        );
    }

    public function searchByTitleOrDate(string $search): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        if (!empty($search)) {
            $queryBuilder
                ->where('e.title LIKE :search')
                ->orWhere('e.chronos LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        return $queryBuilder
            ->orderBy('e.chronos', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'ASC') // Utilisation de l'ID pour respecter l'ordre naturel de la BDD
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Events
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
