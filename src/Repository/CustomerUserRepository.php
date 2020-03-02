<?php

namespace App\Repository;

use App\Entity\CustomerUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CustomerUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerUser[]    findAll()
 * @method CustomerUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerUser::class);
    }

    // /**
    //  * @return CustomerUser[] Returns an array of CustomerUser objects
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
    public function findOneBySomeField($value): ?CustomerUser
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
