<?php

namespace App\Repository;

use App\Entity\LanguageStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LanguageStudent>
 *
 * @method LanguageStudent|null find($id, $lockMode = null, $lockVersion = null)
 * @method LanguageStudent|null findOneBy(array $criteria, array $orderBy = null)
 * @method LanguageStudent[]    findAll()
 * @method LanguageStudent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageStudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LanguageStudent::class);
    }
}
