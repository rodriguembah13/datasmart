<?php

namespace App\Repository;

use App\Entity\ImplObjectif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImplObjectif|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImplObjectif|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImplObjectif[]    findAll()
 * @method ImplObjectif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImplObjectifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplObjectif::class);
    }

    // /**
    //  * @return ImplObjectif[] Returns an array of ImplObjectif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImplObjectif
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
