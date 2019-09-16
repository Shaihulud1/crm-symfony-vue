<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;



class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setUsername('Admin');
        $user->setApitoken('apitoken');

        $user->setPassword(md5(md5(md5('12345'))));
        // $user->setPassword($this->passwordEncoder->encodePassword(
        //     $user,
        //     'test'
        // ));
        $manager->persist($user);
        $manager->flush();
    }
}
