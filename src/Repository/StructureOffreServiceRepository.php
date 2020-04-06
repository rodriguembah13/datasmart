<?php

namespace App\Repository;

use App\Entity\StructureOffreService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StructureOffreService|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructureOffreService|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructureOffreService[]    findAll()
 * @method StructureOffreService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureOffreServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructureOffreService::class);
    }

    // /**
    //  * @return StructureOffreService[] Returns an array of StructureOffreService objects
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
    public function findOneBySomeField($value): ?StructureOffreService
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
