<?php

namespace App\Repository;

use App\Entity\CibleAvatar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CibleAvatar|null find($id, $lockMode = null, $lockVersion = null)
 * @method CibleAvatar|null findOneBy(array $criteria, array $orderBy = null)
 * @method CibleAvatar[]    findAll()
 * @method CibleAvatar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CibleAvatarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CibleAvatar::class);
    }

    // /**
    //  * @return CibleAvatar[] Returns an array of CibleAvatar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CibleAvatar
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
