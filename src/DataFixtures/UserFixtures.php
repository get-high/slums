<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(User::class, 10, function (User $user) {
            $user
                ->setName($this->faker->userName)
                ->setEmail($this->faker->email)
                ->setPassword($this->faker->password)
                ->setUid($this->faker->uuid)
                ->setProvider('provider')
                ->setIsAdmin($this->faker->numberBetween(0,1));
        });
    }
}
