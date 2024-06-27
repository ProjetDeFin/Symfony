<?php

namespace App\DataFixtures;

use App\Entity\JobProfile;
use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectorFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sectors = [
            'Commerce' => '#56CDAD',
            'Industrie mécanique' => '#EB8533',
            'Industrie chimique' => '#FF6550',
            'Automobile' => '#FF6550',
            'Informatique' => '#FE6A50',
            'Réseaux, téléphonie, FAI' => '#4640DE',
            'Tourisme, sport' => '#FF6550',
            'Transport' => '#FF6550',
            'Finances' => '#56CDAD',
            'Loisirs' => '#56CDAD',
            'Alimentation' => '#56CDAD',
            'Santé, bien-être' => '#56CDAD',
            'Immobilier, BTP' => '#56CDAD',
            'Média' => '#56CDAD',
            'Autre' => '#56CDAD',
        ];

        foreach ($sectors as $name => $color) {
            $sector = new Sector();
            $sector->setName($name);
            $sector->setColor($color);

            $this->addReference('sector_' . strtolower(str_replace(' ', '_', $name)), $jobProfile);

            $manager->persist($sector);
        }

        $manager->flush();
    }
}
