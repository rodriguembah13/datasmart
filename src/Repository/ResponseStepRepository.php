<?php

namespace App\Repository;

use App\Entity\ResponseStep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ResponseStep|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseStep|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseStep[]    findAll()
 * @method ResponseStep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseStepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseStep::class);
    }

    // /**
    //  * @return ResponseStep[] Returns an array of ResponseStep objects
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
    public function findOneBySomeField($value): ?ResponseStep
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
