<?php

namespace App\Repository;

use App\Entity\InternshipOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InternshipOffer>
 *
 * @method InternshipOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternshipOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternshipOffer[]    findAll()
 * @method InternshipOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternshipOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InternshipOffer::class);
    }
}
