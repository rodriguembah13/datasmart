<?php

namespace App\Repository;

use App\Entity\ImplAvatar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImplAvatar|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImplAvatar|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImplAvatar[]    findAll()
 * @method ImplAvatar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImplAvatarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplAvatar::class);
    }

    // /**
    //  * @return ImplAvatar[] Returns an array of ImplAvatar objects
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
    public function findOneBySomeField($value): ?ImplAvatar
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
