<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\UserOutput;
use App\Entity\User;

class UserOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param User $user
     */
    public function transform($user, string $to, array $context = [])
    {
        return UserOutput::createFromEntity($user);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return UserOutput::class === $to && $data instanceof User;
    }
}