<?php
/**
 * Created by PhpStorm.
 * User: smartworld
 * Date: 4/1/20
 * Time: 1:02 PM
 */

namespace App\Repository;

use App\Entity\ImplOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImplOffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImplOffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImplOffre[]    findAll()
 * @method ImplOffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImplOffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImplOffre::class);
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
