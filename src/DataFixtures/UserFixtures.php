<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('wick@wick.us');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'wick'));
        $manager->persist($user);
        $user2 = new User();
        $user2->setEmail('john@john.us');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'john'));
        $manager->persist($user2);


        $manager->flush();
    }
}
