<?php

namespace App\Repository;

use App\Entity\MembersStep;
use App\Entity\StepStrategy;
use App\Entity\StrategyDigital;
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

    public function findByUser(StrategyDigital $strategyDigital,MembersStep $membersStep)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $membersStep)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


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
