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
}
