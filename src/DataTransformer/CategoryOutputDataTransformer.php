<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Category;
use App\Model\Category\CategoryResponse;

class CategoryOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = new CategoryResponse();
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
        return CategoryResponse::class === $to && $data instanceof Category;
    }

}