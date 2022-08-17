<?php

namespace App\DataFixtures;

use App\Entity\PostType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $realisation = new PostType();
        $realisation->setName("Réalisation");

        $video = new PostType();
        $video->setName("Video");

        $plusieursImages = new PostType();
        $plusieursImages->setName("Plusieurs images");

        $infographie = new PostType();
        $infographie->setName("Infographie");

        $manager->persist($realisation);
        $manager->persist($video);
        $manager->persist($plusieursImages);
        $manager->persist($infographie);

        $manager->flush();
    }
}
