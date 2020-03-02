<?php

namespace App\Repository;

use App\Entity\Role;
use App\Entity\RolePermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;

/**
 * @method RolePermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method RolePermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method RolePermission[]    findAll()
 * @method RolePermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolePermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RolePermission::class);
    }
    public function saveRolePermission(RolePermission $permission)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($permission);
        $entityManager->flush();
    }

    public function findRolePermission(Role $role, string $permission)
    {
        return $this->findOneBy(['role' => $role, 'permission' => $permission]);
    }

    public function getAllAsArray()
    {
        $qb = $this->createQueryBuilder('rp');

        $qb->select('r.name as role,rp.permission,rp.allowed')
            ->leftJoin('rp.role', 'r');

        return $qb->getQuery()->execute([], AbstractQuery::HYDRATE_ARRAY);
    }
}
