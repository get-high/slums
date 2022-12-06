<?php

namespace App\Dto;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserOutput
{
    #[Groups(["user"])]
    public int $id;

    #[Groups(["user"])]
    public string $name;

    #[Groups("user")]
    public string $email;

    public static function createFromEntity(User $user): self
    {
        $output = new UserOutput();
        $output->id = $user->getId();
        $output->name = $user->getName();
        $output->email = $user->getEmail();

        return $output;
    }
}