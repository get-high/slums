<?php

namespace App\DataFixtures;

use App\Entity\Spot;
use App\Entity\User;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VoteFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private VoteRepository $repository;

    public function __construct(VoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Vote::class, 200, function (Vote $vote) {
            $vote
                ->setRating($this->faker->randomFloat(2, 2, 5))
                ->setUser($this->getRandomReference(User::class))
                ->setSpot($this->getRandomReference(Spot::class))
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
