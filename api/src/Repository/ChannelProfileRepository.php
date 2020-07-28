<?php

namespace App\Repository;

use App\Entity\ChannelProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChannelProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelProfile[]    findAll()
 * @method ChannelProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelProfile::class);
    }

    // /**
    //  * @return ChannelProfile[] Returns an array of ChannelProfile objects
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
    public function findOneBySomeField($value): ?ChannelProfile
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
