<?php

namespace App\Repository;

use App\Entity\StrategyDigital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StrategyDigital|null find($id, $lockMode = null, $lockVersion = null)
 * @method StrategyDigital|null findOneBy(array $criteria, array $orderBy = null)
 * @method StrategyDigital[]    findAll()
 * @method StrategyDigital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StrategyDigitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StrategyDigital::class);
    }

    // /**
    //  * @return StrategyDigital[] Returns an array of StrategyDigital objects
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
    public function findOneBySomeField($value): ?StrategyDigital
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
