<?php

namespace App\DataFixtures;

use App\Entity\DiplomaSearched;
use App\Entity\JobProfile;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiplomaSeachedFixture extends Fixture
{
    public static string $diplomaReference = 'diploma_';
    public function load(ObjectManager $manager): void
    {
        $diplomas = [
            [
                'name' => 'BREVET',
            ],
            [
                'name' => 'CAP, BEP',
            ],
            [
                'name' => 'BAC',
            ],
            [
                'name' => 'BTS, DUT, BUT',
            ],
            [
                'name' => 'Licence',
            ],
            [
                'name' => 'Master, DEA, DESS',
            ],
            [
                'name' => 'DOCTORAT',
            ]
        ];

        foreach ($diplomas as $index => $diplomaData) {
            $diploma = new DiplomaSearched();
            $diploma->setName($diplomaData['name']);

            $this->addReference($this::$diplomaReference.$index, $diploma);

            $manager->persist($diploma);
        }

        $manager->flush();
    }
}
