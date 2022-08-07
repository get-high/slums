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
                ->setTitle($this->faker->sentence)
                ->setSlug($this->faker->slug)
                ->setDescription($this->faker->text(100))
            ;
        });

        $manager->flush();
    }
}
