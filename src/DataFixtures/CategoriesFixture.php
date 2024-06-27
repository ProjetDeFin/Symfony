<?php

namespace App\DataFixtures;

use App\Entity\JobProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobProfiles = [
            'Services aux particuliers',
            'Services aux entreprises',
            'Mairie, collectivité',
            'Association, ONG',
            'Organismes d\'état',
            'Autres'
        ];

        foreach ($jobProfiles as $name => $color) {
            $jobProfile = new JobProfile();
            $jobProfile->setName($name);
            $jobProfile->setColor($color);

            $this->addReference('job_profile_' . strtolower(str_replace(' ', '_', $name)), $jobProfile);

            $manager->persist($jobProfile);
        }

        $manager->flush();
    }
}
