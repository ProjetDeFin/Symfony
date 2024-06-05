<?php

namespace App\Repository;

use App\Entity\JobProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobProfile>
 *
 * @method JobProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobProfile[]    findAll()
 * @method JobProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobProfile::class);
    }
}
