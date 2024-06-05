<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $companies = [
            [
                'name' => 'Company 1',
                'socialReason' => 'Social Reason1',
                'siret' => 123412341234123,
                'workforce' => '100',
                'sellFigure' => 1000.0,
                'creation' => new \DateTime('2000-01-01'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'logo1.png',
                'phone' => '0121567892',
                'email' => 'company1@example.com',
                'websiteUrl' => 'https://www.company1.com',
                'fax' => '0121567892',
                'linkedinUrl' => 'https://www.linkedin.com/company1',
                'facebookUrl' => 'https://www.facebook.com/company1',
                'instagramUrl' => 'https://www.instagram.com/company1',
                'xUrl' => 'https://www.x.com/company1',
            ],
            [
                'name' => 'Company 2',
                'socialReason' => 'Social Reason2',
                'siret' => 12345678401235,
                'workforce' => '200',
                'sellFigure' => 2000.0,
                'creation' => new \DateTime('2000-01-02'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'logo2.png',
                'phone' => '0123456789',
                'email' => 'company2@example.com',
                'websiteUrl' => 'https://www.company2.com',
                'fax' => '0123456789',
                'linkedinUrl' => 'https://www.linkedin.com/company2',
                'facebookUrl' => 'https://www.facebook.com/company2',
                'instagramUrl' => 'https://www.instagram.com/company2',
                'xUrl' => 'https://www.x.com/company2',
            ],
            [
                'name' => 'Company 3',
                'socialReason' => 'Social Reason3',
                'siret' => 123123123123123,
                'workforce' => '300',
                'sellFigure' => 3000.0,
                'creation' => new \DateTime('2000-01-03'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'logo3.png',
                'phone' => '0123123123',
                'email' => 'company3@example.com',
                'websiteUrl' => 'https://www.company3.com',
                'fax' => '0123123123',
                'linkedinUrl' => 'https://www.linkedin.com/company3',
                'facebookUrl' => 'https://www.facebook.com/company3',
                'instagramUrl' => 'https://www.instagram.com/company3',
                'xUrl' => 'https://www.x.com/company3',
            ],
        ];

        foreach ($companies as $companyData) {
            $company = new Company();
            $company->setName($companyData['name']);
            $company->setSocialReason($companyData['socialReason']);
            $company->setSiret($companyData['siret']);
            $company->setWorkforce($companyData['workforce']);
            $company->setSellFigure($companyData['sellFigure']);
            $company->setCreation($companyData['creation']);
            $company->setAddress1($companyData['address1']);
            $company->setCity($companyData['city']);
            $company->setZipCode($companyData['postalCode']);
            $company->setCountry($companyData['country']);
            $company->setLogo($companyData['logo']);
            $company->setPhone($companyData['phone']);
            $company->setEmail($companyData['email']);
            $company->setWebsiteUrl($companyData['websiteUrl']);
            $company->setFax($companyData['fax']);
            $company->setLinkedinUrl($companyData['linkedinUrl']);
            $company->setFacebookUrl($companyData['facebookUrl']);
            $company->setInstagramUrl($companyData['instagramUrl']);
            $company->setXUrl($companyData['xUrl']);

            $this->addReference('company_' . strtolower(str_replace(' ', '_', $companyData['name'])), $company);

            $manager->persist($company);
        }

        $manager->flush();
    }
}
