<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Test;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $test = new Test;
        $test->setTitle('test1');
        // $product = new Product();
        $manager->persist($test);

        $manager->flush();
    }
}
