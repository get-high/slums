<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Category;

class CategoryInputDataTransformer implements DataTransformerInterface
{
    public function __construct(private ValidatorInterface $validator)
    {}

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = []): Category
    {
        $this->validator->validate($data);

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