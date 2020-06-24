<?php

namespace App\Repository;

use App\Entity\ClickTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClickTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClickTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClickTraining[]    findAll()
 * @method ClickTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClickTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClickTraining::class);
    }

    // /**
    //  * @return ClickTraining[] Returns an array of ClickTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClickTraining
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
