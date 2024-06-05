<?php

namespace App\DataFixtures;

use App\Entity\JobProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobProfilesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobProfiles = [
            'Design' => '#56CDAD',
            'Marketing' => '#EB8533',
            'Commercial' => '#FF6550',
            'Business' => '#FF6550',
            'Management' => '#FE6A50',
            'Finance' => '#4640DE',
            'Industrie' => '#FF6550',
            'Informatique' => '#FF6550',
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
