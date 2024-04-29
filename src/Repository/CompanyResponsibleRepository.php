<?php

namespace App\Repository;

use App\Entity\CompanyResponsible;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyResponsible>
 *
 * @method CompanyResponsible|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyResponsible|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyResponsible[]    findAll()
 * @method CompanyResponsible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyResponsibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyResponsible::class);
    }

    public function findCompanyResponsibleByUser(User $user): ?CompanyResponsible
    {
        return $this->createQueryBuilder('cr')
            ->leftJoin('cr.user', 'user')
            ->andWhere('cr.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
