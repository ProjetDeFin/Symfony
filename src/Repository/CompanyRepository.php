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
}
