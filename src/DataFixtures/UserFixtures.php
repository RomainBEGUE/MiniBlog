<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $faker = \Faker\Factory::create('fr_FR');
            for ($i = 1; $i <= 20; $i++) {
                $user = new User();
                $user->setRoles(["ROLE_USER"]);
                $user->setEmail($faker->unique->email());
                $user->setFirstName($faker->firstName($gender = null));
                $user->setLastName($faker->lastName());
                $password = $this->encoder->encodePassword($user, "password");
                $user->setPassword($password);
                $manager->persist($user);
                $this->addReference(User::class . $i, $user);
            }

            $userAdmin = new User();
            $userAdmin->setRoles(["ROLE_ADMIN"]);
            $userAdmin->setEmail("admin@admin.com");
            $passwordAdmin = $this->encoder->encodePassword($userAdmin, "passwordAdmin");
            $userAdmin->setPassword($passwordAdmin);
            $userAdmin->setLastName("Super");
            $userAdmin->setFirstName("Admin");
            $manager->persist($userAdmin);

            $manager->flush();
        }

        /**
         * @var UserPasswordEncoderInterface
         */
        private $encoder;

        public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
}
