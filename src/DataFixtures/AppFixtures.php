<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $superAdmin = new User();
        $superAdmin
            ->setEmail('superadmin@test.fr')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setPassword('$argon2i$v=19$m=12,t=3,p=1$YjE5MjhzenFjaGEwMDAwMA$jkh9yVJgBqsHw0Wb93jS8w')
            ->setFirstname('Super')
            ->setName('Admin')
        ;

        $manager->persist($superAdmin);
        $manager->flush();
    }
}
