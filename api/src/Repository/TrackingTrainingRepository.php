<?php

namespace App\Repository;

use App\Entity\TrackingTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrackingTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackingTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackingTraining[]    findAll()
 * @method TrackingTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackingTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackingTraining::class);
    }

    // /**
    //  * @return TrackingTraining[] Returns an array of TrackingTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrackingTraining
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
