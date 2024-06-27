<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Enum\ApplicationStatusEnum;
use App\Enum\TypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $applications = [
            [
                'status' => ApplicationStatusEnum::APPLICATION,
                'student' => $this->getReference('student1'),
                'title' => 'Application 1',
                'startAt' => '2021-10-01',
                'endAt' => '2021-12-01',
                'type' => TypeEnum::INTERNSHIP,
            ],
            [
                'status' => ApplicationStatusEnum::APPLICATION,
                'student' => $this->getReference('student1'),
                'title' => 'Application 3',
                'startAt' => '2021-10-01',
                'endAt' => '2021-12-01',
                'type' => TypeEnum::ALTERNATION,
            ],
            [
                'status' => ApplicationStatusEnum::APPLICATION,
                'student' => $this->getReference('student1'),
                'title' => 'Application 2',
                'startAt' => '2021-10-01',
                'endAt' => '2021-12-01',
                'type' => TypeEnum::INTERNSHIP,
            ],
        ];

        foreach ($applications as $applicationData) {
            $application = new Application();
            $application->setTitle($applicationData['title']);
            $application->setStartAt(new \DateTimeImmutable($applicationData['startAt']));
            $application->setEndAt(new \DateTimeImmutable($applicationData['endAt']));
            $application->setType($applicationData['type']);
            $application->setStatus($applicationData['status']);

            $application->setStudent($applicationData['student']);

            $manager->persist($application);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
