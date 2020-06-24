<?php

namespace App\Repository;

use App\Entity\FlickTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FlickTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlickTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlickTraining[]    findAll()
 * @method FlickTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlickTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlickTraining::class);
    }

    // /**
    //  * @return FlickTraining[] Returns an array of FlickTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlickTraining
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
