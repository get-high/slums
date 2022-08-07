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
        $this->create(User::class, function (User $user) {
            $user
                ->setName('Admin')
                ->setEmail('admin@mail.ru')
                ->setPassword($this->hasher->hashPassword($user, '123456'))
                ->setUid($this->faker->uuid)
                ->setProvider('provider')
                ->setRoles(['ROLE_ADMIN']);
        });

        $this->createMany(User::class, 10, function (User $user) {
            $user
                ->setName($this->faker->userName)
                ->setEmail($this->faker->email)
                ->setPassword($this->hasher->hashPassword($user, '123456'))
                ->setUid($this->faker->uuid)
                ->setProvider('provider')
                ->setRoles(['ROLE_USER']);
        });

        $manager->flush();
    }
}
