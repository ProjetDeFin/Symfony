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
                'description' => 'Aliquam rhoncus, massa a egestas volutpat, ligula leo rutrum quam, eget tristique eros
                 lectus ac risus. Integer id rhoncus purus. Sed placerat metus sit amet nisi sodales porttitor. Interdum
                  et malesuada fames ac ante ipsum primis in faucibus.Etiam in urna sapien. Mauris accumsan, mauris at
                   commodo vestibulum, diam ipsum congue urna, non pharetra ante risus ac turpis. Maecenas pulvinar 
                   lorem sit amet metus porta, nec lobortis felis maximus. Maecenas ultrices vulputate ultricies. 
                   Donec congue fermentum diam, sit amet varius ipsum fringilla sed',
                'siret' => 123412341234123,
                'workforce' => '100',
                'sellFigure' => 1000.0,
                'creation' => new \DateTime('2000-01-01'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => '/uploads/logo/intel.svg',
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
                'photo1' => '/uploads/company/photo1.jpg',
                'photo2' => '/uploads/company/photo2.jpg',
                'photo3' => '/uploads/company/photo3.jpg',
                'detail1' => '/uploads/company/detail1.jpg',
                'detail2' => '/uploads/company/detail2.jpg',
                'detail3' => '/uploads/company/detail3.jpg',
                'detail4' => '/uploads/company/detail4.jpg',
                'detail5' => '/uploads/company/detail5.jpg',
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
                'description' => 'Aliquam rhoncus, massa a egestas volutpat, ligula leo rutrum quam, eget tristique eros
                 lectus ac risus. Integer id rhoncus purus. Sed placerat metus sit amet nisi sodales porttitor. Interdum
                  et malesuada fames ac ante ipsum primis in faucibus.Etiam in urna sapien. Mauris accumsan, mauris at
                   commodo vestibulum, diam ipsum congue urna, non pharetra ante risus ac turpis. Maecenas pulvinar 
                   lorem sit amet metus porta, nec lobortis felis maximus. Maecenas ultrices vulputate ultricies. 
                   Donec congue fermentum diam, sit amet varius ipsum fringilla sed',
                'siret' => 12345678401235,
                'workforce' => '200',
                'sellFigure' => 2000.0,
                'creation' => new \DateTime('2000-01-02'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => '/uploads/logo/amd.svg',
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
                'photo1' => '/uploads/company/photo1.jpg',
                'photo2' => '/uploads/company/photo2.jpg',
                'photo3' => '/uploads/company/photo3.jpg',
                'detail1' => '/uploads/company/detail1.jpg',
                'detail2' => '/uploads/company/detail2.jpg',
                'detail3' => '/uploads/company/detail3.jpg',
                'detail4' => '/uploads/company/detail4.jpg',
                'detail5' => '/uploads/company/detail5.jpg',
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
                'description' => 'Aliquam rhoncus, massa a egestas volutpat, ligula leo rutrum quam, eget tristique eros
                 lectus ac risus. Integer id rhoncus purus. Sed placerat metus sit amet nisi sodales porttitor. Interdum
                  et malesuada fames ac ante ipsum primis in faucibus.Etiam in urna sapien. Mauris accumsan, mauris at
                   commodo vestibulum, diam ipsum congue urna, non pharetra ante risus ac turpis. Maecenas pulvinar 
                   lorem sit amet metus porta, nec lobortis felis maximus. Maecenas ultrices vulputate ultricies. 
                   Donec congue fermentum diam, sit amet varius ipsum fringilla sed',
                'socialReason' => 'Social Reason3',
                'siret' => 123123123123123,
                'workforce' => '300',
                'sellFigure' => 3000.0,
                'creation' => new \DateTime('2000-01-03'),
                'address1' => '1 rue de la société, 75000 Paris',
                'city' => 'Paris',
                'postalCode' => '75000',
                'country' => 'France',
                'logo' => '/uploads/logo/talkit.svg',
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
                'photo1' => '/uploads/company/photo1.jpg',
                'photo2' => '/uploads/company/photo2.jpg',
                'photo3' => '/uploads/company/photo3.jpg',
                'detail1' => '/uploads/company/detail1.jpg',
                'detail2' => '/uploads/company/detail2.jpg',
                'detail3' => '/uploads/company/detail3.jpg',
                'detail4' => '/uploads/company/detail4.jpg',
                'detail5' => '/uploads/company/detail5.jpg',
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
            $company->setPhoto1($companyData['photo1']);
            $company->setPhoto2($companyData['photo2']);
            $company->setPhoto3($companyData['photo3']);
            $company->setDetail1($companyData['detail1']);
            $company->setDetail2($companyData['detail2']);
            $company->setDetail3($companyData['detail3']);
            $company->setDetail4($companyData['detail4']);
            $company->setDetail5($companyData['detail5']);
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
