<?php

namespace App\Repository;

use App\Entity\CompaniesCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompaniesCategory>
 *
 * @method CompaniesCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompaniesCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompaniesCategory[]    findAll()
 * @method CompaniesCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompaniesCategory::class);
    }

    //    /**
    //     * @return CompaniesCategory[] Returns an array of CompaniesCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompaniesCategory
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
