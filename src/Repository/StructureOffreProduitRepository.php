<?php

namespace App\Repository;

use App\Entity\StructureOffreProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StructureOffreProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructureOffreProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructureOffreProduit[]    findAll()
 * @method StructureOffreProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureOffreProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructureOffreProduit::class);
    }

    // /**
    //  * @return StructureOffreProduit[] Returns an array of StructureOffreProduit objects
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
    public function findOneBySomeField($value): ?StructureOffreProduit
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
