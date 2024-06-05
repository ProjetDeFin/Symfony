<?php

namespace App\DataFixtures;

use App\Entity\InternshipOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InternshipOfferFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $offers = [
            [
                'name' => 'Offer 1',
                'type' => 'Alternance',
                'company' => 'Company 1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 2',
                'type' => 'Stage',
                'company' => 'Company 2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 3',
                'type' => 'Alternance',
                'company' => 'Company 3',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 4',
                'type' => 'Stage',
                'company' => 'Company 4',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 5',
                'type' => 'Alternance',
                'company' => 'Company 5',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 6',
                'type' => 'Stage',
                'company' => 'Company 6',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 7',
                'type' => 'Alternance',
                'company' => 'Company 7',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 8',
                'type' => 'Stage',
                'company' => 'Company 8',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 9',
                'type' => 'Alternance',
                'company' => 'Company 9',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
            [
                'name' => 'Offer 10',
                'type' => 'Stage',
                'company' => 'Company 10',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => ['Design', 'Marketing'],
                'diplomaSearcheds' => ['BTS', 'LICENCE'],
                'skills' => ['PHP', 'Symfony'],
                'startAt' => new \DateTimeImmutable('2023-01-01'),
                'endAt' => new \DateTimeImmutable('2023-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2022-12-31'),
            ],
        ];

        foreach ($offers as $offerData) {
            $offer = new InternshipOffer();
            $offer->setTitle($offerData['name']);
            $offer->setType($offerData['type']);
            $offer->setDescription($offerData['description']);
            $offer->setStartAt($offerData['startAt']);
            $offer->setEndAt($offerData['endAt']);
            $offer->setEndApplyDate($offerData['endApplyDate']);

            foreach ($offerData['jobProfiles'] as $jobProfileName) {
                $jobProfile = $this->getReference('job_profile_' . strtolower(str_replace(' ', '_', $jobProfileName)));
                $offer->addJobProfile($jobProfile);
            }

            foreach ($offerData['diplomaSearcheds'] as $diplomaSearchedName) {
                $diplomaSearched = $this->getReference('diploma_searched_' . strtolower(str_replace(' ', '_', $diplomaSearchedName)));
                $offer->addDiplomaSearched($diplomaSearched);
            }

            foreach ($offerData['skills'] as $skillName) {
                $skill = $this->getReference('skill_' . strtolower(str_replace(' ', '_', $skillName)));
                $offer->addSkill($skill);
            }

            $company = $this->getReference('company_' . strtolower(str_replace(' ', '_', $offerData['company'])));
            $offer->setCompany($company);

            $manager->persist($offer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixture::class,
            JobProfilesFixture::class,
            DiplomaSeachedFixture::class,
            SkillFixture::class,
        ];
    }
}
