<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\InWork;



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
        $user->setFullname('Vasily 1231');
        $user->setPassword(md5(md5(md5("12345"))));
        $inWork = new InWork;
        $inWork->setObjID(242);
        $inWork->setTimeWork(time() + 1800);
        $inWork->setWorkType('NP');
        $user->addInWork($inWork);
        $manager->persist($inWork);
        $manager->persist($user);
        $manager->flush();
        /*
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
            'test'
        ));
        */
    }
}
