<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Services aux particuliers',
            'Services aux entreprises',
            'Mairie, collectivité',
            'Association, ONG',
            'Organismes d\'état',
            'Autres'
        ];

        foreach ($categories as $index => $name) {
            $category = new Category();
            $category->setName($name);

            $this->addReference('category_'.$index, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
