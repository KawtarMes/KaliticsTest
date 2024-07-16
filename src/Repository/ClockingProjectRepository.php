<?php

namespace App\Repository;

use App\Entity\ClockingProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClockingProject>
 *
 * @method ClockingProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClockingProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClockingProject[]    findAll()
 * @method ClockingProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClockingProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClockingProject::class);
    }

//    /**
//     * @return ClockingProject[] Returns an array of ClockingProject objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClockingProject
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
