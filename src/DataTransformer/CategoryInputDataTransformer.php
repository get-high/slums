<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\CategoryInput;
use App\Entity\Category;

class CategoryInputDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {}

    /**
     * @param CategoryInput $input
     */
    public function transform($input, string $to, array $context = []): Category
    {
        $this->validator->validate($input);

        $category = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] ?? null;

        return $input->createOrUpdateEntity($category);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Category) {
            return false;
        }

        return Category::class === $to && null !== ($context['input']['class'] ?? null);
    }
}