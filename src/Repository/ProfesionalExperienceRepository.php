<?php

namespace App\Repository;

use App\Entity\ProfesionalExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProfesionalExperience>
 *
 * @method ProfesionalExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfesionalExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfesionalExperience[]    findAll()
 * @method ProfesionalExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesionalExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfesionalExperience::class);
    }
}
