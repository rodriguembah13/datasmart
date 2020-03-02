<?php

namespace App\Repository;

use App\Entity\StepStrategy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StepStrategy|null find($id, $lockMode = null, $lockVersion = null)
 * @method StepStrategy|null findOneBy(array $criteria, array $orderBy = null)
 * @method StepStrategy[]    findAll()
 * @method StepStrategy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StepStrategyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StepStrategy::class);
    }

    // /**
    //  * @return StepStrategy[] Returns an array of StepStrategy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StepStrategy
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
