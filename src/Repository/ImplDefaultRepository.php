<?php

namespace App\Repository;

use App\Entity\ImplDefault;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImplDefault|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImplDefault|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImplDefault[]    findAll()
 * @method ImplDefault[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImplDefaultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplDefault::class);
    }

    // /**
    //  * @return ImplDefault[] Returns an array of ImplDefault objects
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
    public function findOneBySomeField($value): ?ImplDefault
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
