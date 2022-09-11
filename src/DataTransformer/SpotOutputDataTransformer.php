<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Spot;
use App\Model\Spot\SpotResponse;

class SpotOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = new SpotResponse();
        $output->id = $data->getId();
        $output->title = $data->getTitle();
        $output->slug = $data->getSlug();
        $output->main = $data->isMain();

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SpotResponse::class === $to && $data instanceof Spot;
    }

}