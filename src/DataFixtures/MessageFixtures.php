<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker= \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 60; $i++)
            {
                $message = new Message();
                $message->setAuthor($this->getReference(User::class.mt_rand(1,20)));
                $message->setContent($faker->sentence(mt_rand(4,15)));
                $message->setTopic($this->getReference(Topic::class.mt_rand(1,30)));
                $message->setCreationDate($faker->dateTimeBetween($message->getTopic()->getCreationDate(),'now'));

                $manager->persist($message);
            }

        $manager->flush();
    }

    public function getDependencies()
    {
        return[
          UserFixtures::class, TopicFixtures::class
        ];
    }
}
