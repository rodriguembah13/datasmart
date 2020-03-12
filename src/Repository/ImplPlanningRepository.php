<?php

namespace App\Repository;

use App\Entity\ImplPlanning;
use App\Entity\StrategyDigital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImplPlanning|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImplPlanning|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImplPlanning[]    findAll()
 * @method ImplPlanning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImplPlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplPlanning::class);
    }

    // /**
    //  * @return ImplPlanning[] Returns an array of ImplPlanning objects
    //  */

    public function findByStrategy(StrategyDigital $strategyDigital)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('implentation', 'impl')
            ->andWhere('impl.stepStrategy.strategy = :val')
            ->setParameter('val', $strategyDigital)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?ImplPlanning
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
