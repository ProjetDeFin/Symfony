<?php

namespace App\Repository;

use App\Entity\DiplomaSearched;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiplomaSearched>
 *
 * @method DiplomaSearched|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiplomaSearched|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiplomaSearched[]    findAll()
 * @method DiplomaSearched[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiplomaSearchedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiplomaSearched::class);
    }

    //    /**
    //     * @return DiplomaSearched[] Returns an array of DiplomaSearched objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DiplomaSearched
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
