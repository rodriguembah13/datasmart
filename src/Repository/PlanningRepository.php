<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Planning;
use App\Entity\StrategyDigital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Planning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planning[]    findAll()
 * @method Planning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planning::class);
    }

    public function findMinDate()
    {
        //return $this->cre
    }

    /**
     * @return Planning[] Returns an array of Planning objects
     */
    public function findByStrategy(StrategyDigital $strategyDigital)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.stepStrategy', 'step')
            ->addSelect('step')
            ->andWhere('step.strategy = :val')
            ->setParameter('val', $strategyDigital)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Planning[] Returns an array of Planning objects
     */
    public function findWhereDelaiPass()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.dateEnd <= :val')
            ->andWhere('p.status = :status')
            ->setParameter('val', new \DateTime('now'))
            ->setParameter('status', false)
            ->orderBy('p.dateEnd', 'DESC')
            ->setMaxResults(200)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Planning[] Returns an array of Planning objects
     */
    public function findWhereDelaiPassAndCustomers(Customer $customer)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.stepStrategy', 'stepStrategy')
            ->leftJoin('stepStrategy.strategy', 'strategy')
           /* ->leftJoin('strategy.createBy', 'implPlanning')
            ->addSelect('implPlanning')*/
            ->andWhere('strategy.createBy = :customer')
            ->andWhere('p.dateEnd <= :val')
            ->andWhere('p.status = :status')
            ->setParameter('val', new \DateTime('now'))
            ->setParameter('status', false)
            ->setParameter('customer', $customer)
            ->orderBy('p.dateEnd', 'DESC')
            ->setMaxResults(200)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Planning
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
