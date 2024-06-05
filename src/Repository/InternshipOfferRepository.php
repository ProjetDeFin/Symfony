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

    public function findHome(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.createdAt', 'DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCompany($company): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFilter(array $filters, string $order, string $orderBy, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('i');

        if (!empty($filters['jobProfiles'])) {
            $qb->join('i.jobProfiles', 'jp')
                ->andWhere('jp.id IN (:jobProfiles)')
                ->setParameter('jobProfiles', $filters['jobProfiles']);
        }

        if (!empty($filters['diplomaSearcheds'])) {
            $qb->join('i.diplomaSearcheds', 'ds')
                ->andWhere('ds.id IN (:diplomaSearcheds)')
                ->setParameter('diplomaSearcheds', $filters['diplomaSearcheds']);
        }

        if (!empty($filters['type'])) {
            $qb->andWhere('i.type = :type')
                ->setParameter('type', $filters['type']);
        }

        if (!empty($filters['duration'])) {
            switch ($filters['duration']) {
                case 'lessThan2Month':
                    $qb->andWhere('DATEDIFF(i.endAt, i.startAt) < :duration')
                        ->setParameter('duration', '60');
                    break;
                case 'between2And6Month':
                    $qb->andWhere('DATEDIFF(i.endAt, i.startAt) BETWEEN :betweenStart AND :betweenEnd')
                        ->setParameter('betweenStart', '60')
                        ->setParameter('betweenEnd', '180');
                    break;
                case 'between6And12Month':
                    $qb->andWhere('DATEDIFF(i.endAt, i.startAt) BETWEEN :betweenStart AND :betweenEnd')
                        ->setParameter('betweenStart', '180')
                        ->setParameter('betweenEnd', '365');
                    break;
                case 'moreThan12Month':
                    $qb->andWhere('DATEDIFF(i.endAt, i.startAt) > :duration')
                        ->setParameter('duration', '365');
                    break;
                default:
                    throw new \InvalidArgumentException("Durée de filtre invalide: " . $filters['duration']);
            }
        }

        $qb->orderBy('i.' . $orderBy, $order)
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);

        return $qb->getQuery()->getResult();
    }
}
