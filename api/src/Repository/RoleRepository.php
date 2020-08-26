<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    private $superAdminRoles = [];
    
    public function __construct(ManagerRegistry $registry, array $superAdminRoles = [])
    {
        $this->superAdminRoles = $superAdminRoles;
        parent::__construct($registry, Role::class);
    }

    public function getNotSuperAdminRoles()
    {
        $qb = $this->createQueryBuilder('e');
        return $this->createQueryBuilder('r')
          ->andWhere($qb->expr()->notIn('r.roleKey', ':values'))
          ->setParameter('values', $this->superAdminRoles)
          ->getQuery()
          ->getResult();
    }
  

    // /**
    //  * @return Role[] Returns an array of Role objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Role
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
