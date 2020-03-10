<?php

namespace App\Repository;

use App\Entity\CustomerUser;
use App\Entity\MembersStep;
use App\Entity\StrategyDigital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MembersStep|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembersStep|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembersStep[]    findAll()
 * @method MembersStep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembersStepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembersStep::class);
    }

    // /**
    //  * @return MembersStep[] Returns an array of MembersStep objects
    //  */

    public function findByCustomer(StrategyDigital $strategyDigital, CustomerUser $customerUser)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.stepStrategy', 'step')
            ->addSelect('step')
            ->andWhere('step.strategy = :str')
            ->andWhere('m.customerUser =:cus')
            ->setParameter('cus', $customerUser)
            ->setParameter('str', $strategyDigital)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?MembersStep
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
