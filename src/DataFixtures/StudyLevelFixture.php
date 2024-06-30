<?php

namespace App\DataFixtures;

use App\Entity\JobProfile;
use App\Entity\Skill;
use App\Entity\StudyLevel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudyLevelFixture extends Fixture
{
    public static string $studyLevelsReference = 'study_level_';
    public function load(ObjectManager $manager): void
    {
        $studyLevels = [-3, -2, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8];

        foreach ($studyLevels as $index => $studyLevelData) {
            $studyLevel = new StudyLevel();
            $studyLevel->setLevel($studyLevelData);

            $this->addReference($this::$studyLevelsReference.$index, $studyLevel);

            $manager->persist($studyLevel);
        }

        $manager->flush();
    }
}
