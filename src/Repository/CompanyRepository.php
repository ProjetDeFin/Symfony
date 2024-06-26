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

        if (!empty($filters['sectors'] && $filters['sectors'] !== 'all')) {
            $qb->andWhere('c.sector IN (:sectors)')
                ->setParameter('sectors', $filters['sectors']);
        }

        if (!empty($filters['categories'])) {
            $qb->andWhere('c.categories IN (:categories)')
                ->setParameter('categories', $filters['categories']);
        }

        if (!empty($filters['size'])) {
            switch ($filters['size']) {
                case '1-9':
                    $qb->andWhere('c.workforce BETWEEN :start AND :end')
                        ->setParameter('start', '1')
                        ->setParameter('end', '9');
                    break;
                case '10-49':
                    $qb->andWhere('c.workforce BETWEEN :start AND :end')
                        ->setParameter('start', '10')
                        ->setParameter('end', '49');
                    break;
                case '50-99':
                    $qb->andWhere('c.workforce BETWEEN :start AND :end')
                        ->setParameter('start', '50')
                        ->setParameter('end', '99');
                    break;
                case '100-249':
                    $qb->andWhere('c.workforce BETWEEN :start AND :end')
                        ->setParameter('start', '100')
                        ->setParameter('end', '249');
                    break;
                case '250-999':
                    $qb->andWhere('c.workforce BETWEEN :start AND :end')
                        ->setParameter('start', '250')
                        ->setParameter('end', '999');
                    break;
                case '1000+':
                    $qb->andWhere('c.workforce >= :workforce')
                        ->setParameter('workforce', '1000');
                    break;
                default:
                    throw new \InvalidArgumentException("Filtre effectif invalide : " . $filters['size']);
            }
        }

        $qb->orderBy('c.' . $orderBy, $order)
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        return $qb->getQuery()->getResult();
    }
}
