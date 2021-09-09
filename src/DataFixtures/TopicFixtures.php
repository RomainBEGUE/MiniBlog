<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TopicFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i=1; $i<= 30; $i++)
            {
                $topic = new Topic();
                $topic->setAuthor($this->getReference(User::class.mt_rand(1,20)));
                $topic->setCreationDate($faker->dateTimeBetween('-2years','now'));
                $topic->setIsPrivate(mt_rand(1,2));

                $this->addReference(Topic::class.$i, $topic);
                $manager->persist($topic);
            }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return[
            UserFixtures::class
        ];
    }
}
