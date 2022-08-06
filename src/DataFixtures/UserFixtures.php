<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(User::class, 10, function (User $user) {
            $user
                ->setName($this->faker->userName)
                ->setEmail($this->faker->email)
                ->setPassword($this->hasher->hashPassword($user, '123456'))
                ->setUid($this->faker->uuid)
                ->setProvider('provider')
                ->setRoles($this->faker->randomElement([['ROLE_ADMIN'], ['ROLE_USER']]));
        });
    }
}
