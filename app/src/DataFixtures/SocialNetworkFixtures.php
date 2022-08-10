<?php

namespace App\DataFixtures;

use App\Entity\SocialNetwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SocialNetworkFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $facebook = new SocialNetwork("Facebook", "", "");
        $twitter = new SocialNetwork("Twitter", "", "");
        $instagram = new SocialNetwork("Instagram", "", "");
        $linkedIn = new SocialNetwork("LinkedIn", "", "");

        $manager->persist($facebook);
        $manager->persist($twitter);
        $manager->persist($instagram);
        $manager->persist($linkedIn);

        $manager->flush();
    }
}
