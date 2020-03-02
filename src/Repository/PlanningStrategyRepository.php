<?php

namespace App\Repository;

use App\Entity\PlanningStrategy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlanningStrategy|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningStrategy|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningStrategy[]    findAll()
 * @method PlanningStrategy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningStrategyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningStrategy::class);
    }

    // /**
    //  * @return PlanningStrategy[] Returns an array of PlanningStrategy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanningStrategy
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
