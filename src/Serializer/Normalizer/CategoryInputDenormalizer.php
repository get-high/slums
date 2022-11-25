<?php

namespace App\Serializer\Normalizer;

use App\Dto\CategoryInput;
use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CategoryInputDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(
        private ObjectNormalizer $objectNormalizer,
    )
    {}

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $this->createDto($context);

        return $this->objectNormalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === CategoryInput::class;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    private function createDto(array $context): CategoryInput
    {
        $entity = $context['object_to_populate'] ?? null;

        if ($entity && !$entity instanceof Category) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }

        return CategoryInput::createFromEntity($entity);
    }
}