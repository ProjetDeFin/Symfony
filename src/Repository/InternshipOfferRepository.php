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

    public function findByFilter(array $filters, ?string $order, string $orderBy, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('i');

        if (!empty($filters['profiles'])) {
            $qb->join('i.jobProfiles', 'jp',)
                ->andWhere('jp.name IN (:jobProfiles)')
                ->setParameter('jobProfiles', $filters['profiles']);
        }

        if (!empty($filters['type'])) {
            $qb->andWhere('i.type = :type')
                ->setParameter('type', $filters['type']);
        }

        if (!empty($filters['levels'])) {
            $qb->join('i.diplomaSearcheds', 'ds')
                ->andWhere('ds.name IN (:diplomaSearcheds)')
                ->setParameter('diplomaSearcheds', $filters['levels']);
        }

        if (!empty($filters['duration'])) {
            $orX = $qb->expr()->orX();
            foreach ($filters['duration'] as $duration) {
                switch ($duration) {
                    case 'Moins de 2 mois':
                        $orX->add($qb->expr()->lt('DATE_DIFF(i.endAt, i.startAt)', ':lessThan2Month'));
                        $qb->setParameter('lessThan2Month', 60);
                        break;
                    case 'Entre 2 et 6 mois':
                        $orX->add($qb->expr()->between('DATE_DIFF(i.endAt, i.startAt)', ':between2And6MonthStart', ':between2And6MonthEnd'));
                        $qb->setParameter('between2And6MonthStart', 60)
                            ->setParameter('between2And6MonthEnd', 180);
                        break;
                    case 'Entre 6 et 12 mois':
                        $orX->add($qb->expr()->between('DATE_DIFF(i.endAt, i.startAt)', ':between6And12MonthStart', ':between6And12MonthEnd'));
                        $qb->setParameter('between6And12MonthStart', 180)
                            ->setParameter('between6And12MonthEnd', 365);
                        break;
                    case 'Plus de 12 mois':
                        $orX->add($qb->expr()->gt('DATE_DIFF(i.endAt, i.startAt)', ':moreThan12Month'));
                        $qb->setParameter('moreThan12Month', 365);
                        break;
                    default:
                        throw new \InvalidArgumentException("Durée de filtre invalide: " . $duration);
                }
            }
            $qb->andWhere($orX);
        }


        $qb->andWhere('i.endApplyDate > :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('i.'.$orderBy, $order)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);


        return $qb->getQuery()->getResult();
    }
}
