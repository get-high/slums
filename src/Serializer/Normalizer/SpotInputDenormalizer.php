<?php

namespace App\Serializer\Normalizer;

use App\Dto\SpotInput;
use App\Entity\Spot;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SpotInputDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
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
        return $type === SpotInput::class;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    private function createDto(array $context): SpotInput
    {
        $entity = $context['object_to_populate'] ?? null;

        if ($entity && !$entity instanceof Spot) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }

        return SpotInput::createFromEntity($entity);
    }
}