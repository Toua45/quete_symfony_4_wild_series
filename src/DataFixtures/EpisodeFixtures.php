<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i <= 50; $i++) {
            $episode = new Episode();
            $slugify = new Slugify();
            $episode->setTitle($faker->sentence);
            $episode->setNumber($faker->randomDigit);
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_' . rand(1,20)));
            $episode->setSlug($slugify->generate($episode->getTitle()));
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()

    {
        return [SeasonFixtures::class];
    }
}