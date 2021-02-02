<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;
    private $pwEncoder;

    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $pwEncoder) {
        $this->slugger = $slugger;
        $this->pwEncoder = $pwEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Creating a Faker instance to generate random data
        $faker = Factory::create('fr-FR');

        // Creating an User to log in
        $user = new User();
        $user->setEmail('jasond59400@hotmail.fr');
        $user->setPassword($this->pwEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-0', $user); // Recovers the admin later
        $manager->persist($user); // Forces the query to insert an User

        // Creating random users

    }
}
