<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SpotFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Spot::class, 50, function (Spot $spot) {
            $spot
                ->setTitle($this->faker->sentence)
                ->setSlug($this->faker->slug)
                ->setMain($this->faker->numberBetween(0, 1))
                ->setAddress($this->faker->address)
                ->setDescription($this->faker->text(50))
                ->setContent($this->faker->paragraphs(3,true))
                ->setHowToGet($this->faker->text(50))
                ->setRating($this->faker->randomFloat(2, 0, 5))
                ->setLat($this->faker->randomFloat(14, 59, 60))
                ->setLng($this->faker->randomFloat(14, 30, 31))
                ->setViews($this->faker->numberBetween(0, 500))
                ->setYears($this->faker->numberBetween(1850, 1900) . '-' . $this->faker->numberBetween(1900,1950))
                ->setAuthors($this->faker->name)
                ->setCreator($this->getRandomReference(User::class))
            ;

            if ($this->faker->boolean(60)) {
                $spot->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $categories = [];
            for ($i = 0; $i < $this->faker->numberBetween(1,3); $i++) {
                $categories[] = $this->getRandomReference(Category::class);
            }

            foreach ($categories as $category) {
                $spot->addCategory($category);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
