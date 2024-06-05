<?php

namespace App\DataFixtures;

use App\Entity\DiplomaSearched;
use App\Entity\JobProfile;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiplomaSeachedFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $diplomas = [
            [
                'name' => 'BAC',
            ],
            [
                'name' => 'CAP',
            ],
            [
                'name' => 'BTS',
            ],
            [
                'name' => 'LICENCE',
            ],
            [
                'name' => 'MASTER',
            ],
        ];

        foreach ($diplomas as $diplomaData) {
            $diploma = new DiplomaSearched();
            $diploma->setName($diplomaData['name']);

            $manager->persist($diploma);
        }

        $manager->flush();
    }
}
