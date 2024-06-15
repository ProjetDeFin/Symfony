<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyResponsible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function countCompanyResponsibleInCompany(Company $company): int
    {
        $qb = $this->createQueryBuilder('c')
        ->select('COUNT(cr.id)') // Count the ids of CompanyResponsible entities
        ->leftJoin(CompanyResponsible::class, 'cr', 'WHERE', 'cr.company = c')
        ->where('c.id = :id')
            ->setParameter('id', $company->getId())
            ->getQuery();

        return (int) $qb->getSingleScalarResult(); // Ensures that the result is returned as an integer
    }


    // Todo add sponsoring for company
    public function findHome(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFilter(array $filters, string $order, string $orderBy, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($filters['duration'])) {
            switch ($filters['duration']) {
                case 'lessThan2Month':
                    $qb->andWhere('DATEDIFF(c.endAt, c.startAt) < :duration')
                        ->setParameter('duration', '60');
                    break;
                case 'between2And6Month':
                    $qb->andWhere('DATEDIFF(c.endAt, c.startAt) BETWEEN :betweenStart AND :betweenEnd')
                        ->setParameter('betweenStart', '60')
                        ->setParameter('betweenEnd', '180');
                    break;
                case 'between6And12Month':
                    $qb->andWhere('DATEDIFF(c.endAt, c.startAt) BETWEEN :betweenStart AND :betweenEnd')
                        ->setParameter('betweenStart', '180')
                        ->setParameter('betweenEnd', '365');
                    break;
                case 'moreThan12Month':
                    $qb->andWhere('DATEDIFF(c.endAt, c.startAt) > :duration')
                        ->setParameter('duration', '365');
                    break;
                default:
                    throw new \InvalidArgumentException("Durée de filtre invalide: " . $filters['duration']);
            }
        }

        $qb->orderBy('c.' . $orderBy, $order)
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);

        return $qb->getQuery()->getResult();
    }
}
