<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Category;

class CategoryInputDataTransformer implements DataTransformerInterface
{
    public function __construct()
    {}

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = []): Category
    {
        return (new Category())
            ->setTitle($data->title)
            ->setSlug($data->slug)
            ->setMain($data->main);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Category) {
            return false;
        }

        return Category::class === $to && null !== ($context['input']['class'] ?? null);
    }
}