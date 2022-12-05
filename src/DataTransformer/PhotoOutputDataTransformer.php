<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\PhotoOutput;
use App\Entity\Photo;

class PhotoOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Photo $photo
     */
    public function transform($photo, string $to, array $context = [])
    {
        return PhotoOutput::createFromEntity($photo);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return PhotoOutput::class === $to && $data instanceof Photo;
    }
}