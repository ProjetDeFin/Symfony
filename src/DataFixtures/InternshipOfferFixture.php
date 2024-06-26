<?php

namespace App\DataFixtures;

use App\Entity\DesiredProfile;
use App\Entity\InternshipOffer;
use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InternshipOfferFixture extends Fixture implements DependentFixtureInterface
{
    public static string $offerReference = 'offer_';
    public function load(ObjectManager $manager): void
    {
        $offers = [
            [
                'name' => 'Offer 1',
                'type' => 'Alternance',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 2',
                'type' => 'Stage',
                'company' => $this->getReference(CompanyFixture::$companyReference.'1'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'4'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'1'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'6'),
                    $this->getReference(SkillFixture::$skillReference.'10'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 3',
                'type' => 'Alternance',
                'company' => $this->getReference(CompanyFixture::$companyReference.'2'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'5'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'6'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'1'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'2'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 4',
                'type' => 'Stage',
                'company' => $this->getReference(CompanyFixture::$companyReference.'2'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'2'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'5'),
                    $this->getReference(SkillFixture::$skillReference.'11'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 5',
                'type' => 'Alternance',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 6',
                'type' => 'Stage',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 7',
                'type' => 'Alternance',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 8',
                'type' => 'Stage',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 9',
                'type' => 'Alternance',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
            [
                'name' => 'Offer 10',
                'type' => 'Stage',
                'company' => $this->getReference(CompanyFixture::$companyReference.'0'),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec.',
                'jobProfiles' => [
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'0'),
                    $this->getReference(JobProfilesFixture::$jobProfileReference.'1'),
                ],
                'diplomasSearched' => [
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'3'),
                    $this->getReference(DiplomaSeachedFixture::$diplomaReference.'4'),
                ],
                'skills' => [
                    $this->getReference(SkillFixture::$skillReference.'0'),
                    $this->getReference(SkillFixture::$skillReference.'1'),
                ],
                'startAt' => new \DateTimeImmutable('2025-01-01'),
                'endAt' => new \DateTimeImmutable('2025-03-01'),
                'endApplyDate' => new \DateTimeImmutable('2025-12-31'),
                'startApplyDate' => new \DateTimeImmutable('2025-01-01'),
                'missions' => [
                    'Engagement de la communauté pour s\'assurer qu\'elle est soutenue et activement représentée en ligne',
                    'Se concentrer sur la publication de contenu sur les médias sociaux',
                    'Soutien au marketing et à la stratégie',
                ],
                'desiredProfiles' => [
                    'Vous êtes passionné par le digital et pratiquez les principaux réseaux sociaux',
                    'Vous avez le sens des relations humaines et du travail en équipe',
                ]
            ],
        ];

        foreach ($offers as $index => $offerData) {
            $offer = new InternshipOffer();
            $offer->setTitle($offerData['name']);
            $offer->setType($offerData['type']);
            $offer->setDescription($offerData['description']);
            $offer->setStartAt($offerData['startAt']);
            $offer->setEndAt($offerData['endAt']);
            $offer->setEndApplyDate($offerData['endApplyDate']);
            $offer->setStartApplyDate($offerData['startApplyDate']);

            foreach ($offerData['jobProfiles'] as $jobProfile) {
                $offer->addJobProfile($jobProfile);
            }

            foreach ($offerData['diplomasSearched'] as $diplomaSearched) {
                $offer->addDiplomaSearched($diplomaSearched);
            }

            foreach ($offerData['skills'] as $skill) {
                $offer->addSkill($skill);
            }

            foreach ($offerData['missions'] as $missionDescription) {
                $mission = new Mission();
                $mission->setDescription($missionDescription);
                $mission->setInternshipOffer($offer);
                $manager->persist($mission);
            }

            foreach ($offerData['desiredProfiles'] as $profileDescription) {
                $profile = new DesiredProfile();
                $profile->setDescription($profileDescription);
                $profile->setInternshipOffer($offer);
                $manager->persist($profile);
            }

            $offer->setCompany($offerData['company']);

            $this->addReference($this::$offerReference.$index, $offer);

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
