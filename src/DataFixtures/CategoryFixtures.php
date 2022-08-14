<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Category::class, 10, function (Category $category) {
            $category
                ->setTitle($this->faker->word)
                ->setSlug($this->faker->word)
                ->setDescription($this->faker->text(100))
                ->setMain($this->faker->numberBetween(0, 1))
            ;
        });

        $manager->flush();
    }
}
