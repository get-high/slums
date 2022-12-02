<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\Spot\SpotOutput;
use App\Entity\Spot;

class SpotOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Spot $spot
     */
    public function transform($spot, string $to, array $context = [])
    {
        return SpotOutput::createFromEntity($spot);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SpotOutput::class === $to && $data instanceof Spot;
    }
}