<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyResponsible;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function countCompanyResponsible(Company $company): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id)')
            ->where('u.roles LIKE :role')
            ->andWhere('u.company = :company')  // Assuming the User entity has a 'company' relation
            ->setParameters([
                'role' => '%"ROLE_COMPANY_RESPONSIBLE"%',
                'company' => $company
            ]);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    public function findCompanyByUser(string $id): Company
    {
        return $this->createQueryBuilder('u')
            ->select('c')
            ->join(CompanyResponsible::class, 'cr', 'WITH', 'cr.user = u')
            ->join(Company::class, 'c', 'WITH', 'c = cr.company')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
