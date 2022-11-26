<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\SpotInput;
use App\Entity\Spot;
use Symfony\Component\Security\Core\Security;

class SpotInputDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private Security $security,
        private ValidatorInterface $validator,
    ) {}

    /**
     * @param SpotInput $input
     */
    public function transform($input, string $to, array $context = []): Spot
    {
        $this->validator->validate($input);

        $spot = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] ?? null;

        return $input->createOrUpdateEntity($spot, $this->security->getUser());
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Spot) {
            return false;
        }

        return Spot::class === $to && null !== ($context['input']['class'] ?? null);
    }
}