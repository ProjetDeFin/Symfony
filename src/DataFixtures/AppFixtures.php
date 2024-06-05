<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyResponsible;
use App\Entity\Student;
use App\Entity\User;
use App\Enum\UserGenderEnum;
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
            ->setLastName('Admin')
            ->setCivility(UserGenderEnum::OTHER)
        ;

        $manager->persist($superAdmin);

        $studentUser = new User();
        $studentUser->setEmail('student@example.com');
        $studentUser->setRoles(['ROLE_STUDENT']);
        $studentUser->setFirstname('Student');
        $studentUser->setLastName('User');
        $studentUser->setCivility(UserGenderEnum::OTHER);
        $studentUser->setPassword('$argon2i$v=19$m=12,t=3,p=1$YjE5MjhzenFjaGEwMDAwMA$jkh9yVJgBqsHw0Wb93jS8w');
        $manager->persist($studentUser);

        // Create a student and link it to the user
        $student = new Student();
        $student->setUser($studentUser);
        $student->setBirthday(new \DateTime('1990-01-01'));
        $student->setAddress1('1 rue de la Paix');
        $student->setCity('Paris');
        $student->setZipCode('75000');
        $student->setCountry('France');
        $student->setMobile('0123456789');
        $manager->persist($student);

        $company = new Company();
        $company->setName('Company Name');
        $company->setAddress1('1 rue de la Paix');
        $company->setCity('Paris');
        $company->setZipCode('75000');
        $company->setCountry('France');
        $company->setPhone('0123456789');
        $company->setEmail('company.admin@example.com');
        $company->setSocialReason('Company Social Reason');
        $company->setSiret('12345678901234');
        $company->setWorkforce(100);
        $company->setCreation(new \DateTime('1990-01-01'));
        $manager->persist($company);

        $companyResponsableUser = new User();
        $companyResponsableUser->setEmail('company.admin@example.com');
        $companyResponsableUser->setRoles(['ROLE_COMPANY_RESPONSIBLE']);
        $companyResponsableUser->setFirstname('Company');
        $companyResponsableUser->setLastName('Admin');
        $companyResponsableUser->setCivility(UserGenderEnum::OTHER);
        $companyResponsableUser->setPassword('$argon2i$v=19$m=12,t=3,p=1$YjE5MjhzenFjaGEwMDAwMA$jkh9yVJgBqsHw0Wb93jS8w');
        $manager->persist($companyResponsableUser);

        $companyResponsable = new CompanyResponsible();
        $companyResponsable->setUser($companyResponsableUser);
        $companyResponsable->setCompany($company);
        $companyResponsable->setPosition('CEO');
        $companyResponsable->setPhone('0123456789');
        $manager->persist($companyResponsable);


        $manager->flush();
    }
}
