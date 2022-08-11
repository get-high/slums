<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment
                ->setContent($this->faker->paragraphs(3,true))
                ->setUser($this->getRandomReference(User::class))
                ->setSpot($this->getRandomReference(Spot::class))
                ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'))
            ;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SpotFixtures::class,
        ];
    }
}
