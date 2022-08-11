<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Spot;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Photo::class, 50, function (Photo $photo) {
            $photo
                ->setDescription($this->faker->text(200))
                ->setOrderBy($this->faker->numberBetween(0,10))
                ->setSpot($this->getRandomReference(Spot::class))
            ;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SpotFixtures::class,
        ];
    }
}
