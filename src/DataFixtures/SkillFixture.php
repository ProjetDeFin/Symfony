<?php

namespace App\DataFixtures;

use App\Entity\JobProfile;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixture extends Fixture
{
    public static string $skillReference = 'skill_';
    public function load(ObjectManager $manager): void
    {
        $skills = [
            [
                'name' => 'PHP',
            ],
            [
                'name' => 'Symfony',
            ],
            [
                'name' => 'Laravel',
            ],
            [
                'name' => 'Python',
            ],
            [
                'name' => 'Django',
            ],
            [
                'name' => 'Java',
            ],
            [
                'name' => 'Spring',
            ],
            [
                'name' => 'C#',
            ],
            [
                'name' => 'ASP.NET',
            ],
            [
                'name' => 'Ruby',
            ],
            [
                'name' => 'Ruby on Rails',
            ],
            [
                'name' => 'JavaScript',
            ],
            [
                'name' => 'React',
            ],
            [
                'name' => 'Angular',
            ],
            [
                'name' => 'Vue.js',
            ],
            [
                'name' => 'Node.js',
            ],
            [
                'name' => 'HTML',
            ],
            [
                'name' => 'CSS',
            ],
            [
                'name' => 'SASS',
            ],
            [
                'name' => 'LESS',
            ],
            [
                'name' => 'Bootstrap',
            ],
            [
                'name' => 'Tailwind CSS',
            ],
            [
                'name' => 'MySQL',
            ],
            [
                'name' => 'PostgreSQL',
            ],
            [
                'name' => 'MongoDB',
            ],
            [
                'name' => 'SQLite',
            ],
            [
                'name' => 'Oracle',
            ],
            [
                'name' => 'SQL Server',
            ],
            [
                'name' => 'Git',
            ],
            [
                'name' => 'Docker',
            ],
            [
                'name' => 'Kubernetes',
            ],
            [
                'name' => 'Jenkins',
            ],
            [
                'name' => 'Travis CI',
            ],
            [
                'name' => 'Circle CI',
            ],
            [
                'name' => 'AWS',
            ],
            [
                'name' => 'Azure',
            ],
            [
                'name' => 'Google Cloud',
            ],
            [
                'name' => 'Heroku',
            ],
            [
                'name' => 'Netlify',
            ],
            [
                'name' => 'Vercel',
            ],
            [
                'name' => 'Nginx',
            ],
            [
                'name' => 'Apache',
            ],
            [
                'name' => 'IIS',
            ],
            [
                'name' => 'Linux',
            ],
            [
                'name' => 'Windows',
            ],
        ];

        foreach ($skills as $index => $skillData) {
            $skill = new Skill();
            $skill->setName($skillData['name']);

            $this->addReference($this::$skillReference.$index, $skill);

            $manager->persist($skill);
        }

        $manager->flush();
    }
}
