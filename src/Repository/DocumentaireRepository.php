<?php

namespace App\Repository;

use App\Entity\Documentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Documentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documentaire[]    findAll()
 * @method Documentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documentaire::class);
    }

    // /**
    //  * @return Documentaire[] Returns an array of Documentaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Documentaire
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
