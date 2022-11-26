<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\CategoryOutput;
use App\Entity\Category;

class CategoryOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Category $category
     */
    public function transform($category, string $to, array $context = [])
    {
        return CategoryOutput::createFromEntity($category);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CategoryOutput::class === $to && $data instanceof Category;
    }
}