<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures
{
    private UserPasswordHasherInterface $hasher;

    private ImageUploader $avatarUploader;

    private UserRepository $repository;

    private static $userImages = [
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
    ];

    public function __construct(UserRepository $repository, ImageUploader $avatarUploader, UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->repository = $repository;
        $this->avatarUploader = $avatarUploader;
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
                ->setRoles(['ROLE_ADMIN'])
            ;
        });

        $this->createMany(User::class, 10, function (User $user) {
            $user
                ->setName($this->faker->userName)
                ->setEmail($this->faker->email)
                ->setPassword($this->hasher->hashPassword($user, '123456'))
                ->setUid($this->faker->uuid)
                ->setProvider('provider')
                ->setRoles(['ROLE_USER'])
            ;
        });

        $manager->flush();

        $users = $this->repository->findAll();

        foreach ($users as $user) {
            $fileName = $this->faker->randomElement(self::$userImages);

            $this->avatarUploader->uploadImage(new File(dirname(__DIR__, 2) .'/public/images/users/'.$fileName), $user);
        }
    }
}
