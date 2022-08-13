<?php

namespace App\DataFixtures;

use App\Entity\Spot;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WasWillFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadData(ObjectManager $manager): void
    {
        $users = $this->repository->findAll();

        foreach ($users as $user) {
            $spotsUserWas = [];
            $spotsUserWill = [];

            for ($i = 0; $i < $this->faker->numberBetween(1,3); $i++) {
                $spotsUserWas[] = $this->getRandomReference(Spot::class);
            }

            for ($i = 0; $i < $this->faker->numberBetween(1,3); $i++) {
                $spotsUserWill[] = $this->getRandomReference(Spot::class);
            }

            foreach ($spotsUserWas as $spotUserWas) {
                $user->addSpotUserWas($spotUserWas);
            }

            foreach ($spotsUserWill as $spotUserWill) {
                $user->addSpotUserWill($spotUserWill);
            }

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            SpotFixtures::class,
        ];
    }
}
