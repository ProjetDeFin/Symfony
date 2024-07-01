<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixture extends Fixture implements DependentFixtureInterface
{
    public static string $companyReference = 'company_';
    public function load(ObjectManager $manager): void
    {
        $companies = [
            [
                'name' => 'Company 1',
                'socialReason' => 'Social Reason1',
                'description' => 'Description1',
                'siret' => 123412341234123,
                'workforce' => '100',
                'sellFigure' => 1000.0,
                'creation' => new \DateTime('2000-01-01'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'intel.svg',
                'phone' => '0121567892',
                'email' => 'company1@example.com',
                'websiteUrl' => 'https://www.company1.com',
                'fax' => '0121567892',
                'linkedinUrl' => 'https://www.linkedin.com/company1',
                'facebookUrl' => 'https://www.facebook.com/company1',
                'instagramUrl' => 'https://www.instagram.com/company1',
                'xUrl' => 'https://www.x.com/company1',
                'latitude' => 48.856614,
                'longitude' => 2.3522219,
                'categories' => [
                    $this->getReference('category_0'),
                    $this->getReference('category_1'),
                ],
                'sectors' => [
                    $this->getReference('sector_0'),
                ],
            ],
            [
                'name' => 'Company 2',
                'socialReason' => 'Social Reason2',
                'description' => 'Description1',
                'siret' => 12345678401235,
                'workforce' => '200',
                'sellFigure' => 2000.0,
                'creation' => new \DateTime('2000-01-02'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'amd.svg',
                'phone' => '0123456789',
                'email' => 'company2@example.com',
                'websiteUrl' => 'https://www.company2.com',
                'fax' => '0123456789',
                'linkedinUrl' => 'https://www.linkedin.com/company2',
                'facebookUrl' => 'https://www.facebook.com/company2',
                'instagramUrl' => 'https://www.instagram.com/company2',
                'xUrl' => 'https://www.x.com/company2',
                'latitude' => 48.856614,
                'longitude' => 2.3522219,
                'categories' => [
                    $this->getReference('category_1'),
                ],
                'sectors' => [
                    $this->getReference('sector_2'),
                    $this->getReference('sector_3'),
                ],
            ],
            [
                'name' => 'Company 3',
                'description' => 'Description3',
                'socialReason' => 'Social Reason3',
                'siret' => 123123123123123,
                'workforce' => '300',
                'sellFigure' => 3000.0,
                'creation' => new \DateTime('2000-01-03'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => 'talkit.svg',
                'phone' => '0123123123',
                'email' => 'company3@example.com',
                'websiteUrl' => 'https://www.company3.com',
                'fax' => '0123123123',
                'linkedinUrl' => 'https://www.linkedin.com/company3',
                'facebookUrl' => 'https://www.facebook.com/company3',
                'instagramUrl' => 'https://www.instagram.com/company3',
                'xUrl' => 'https://www.x.com/company3',
                'latitude' => 48.856614,
                'longitude' => 2.3522219,
                'categories' => [
                    $this->getReference('category_2'),
                    $this->getReference('category_4'),
                    $this->getReference('category_5'),
                ],
                'sectors' => [
                    $this->getReference('sector_4'),
                    $this->getReference('sector_5'),
                    $this->getReference('sector_6'),
                ],
            ],
        ];

        foreach ($companies as $index => $companyData) {
            $company = new Company();
            $company->setName($companyData['name']);
            $company->setDescription($companyData['description']);
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
            $company->setLatitude($companyData['latitude']);
            $company->setLongitude($companyData['longitude']);
            foreach ($companyData['categories'] as $category) {
                $company->addCategory($category);
            }
            foreach ($companyData['sectors'] as $sector) {
                $company->addSector($sector);
            }

            $this->addReference($this::$companyReference.$index, $company);

            $manager->persist($company);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            SectorFixture::class,
        ];
    }
}
