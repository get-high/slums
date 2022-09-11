<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Spot;
use App\Repository\CategoryRepository;
use Symfony\Component\Security\Core\Security;

class SpotInputDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private Security $security,
        private CategoryRepository $categoryRepository)
    {}

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = []): Spot
    {
        $this->validator->validate($data);

        $spot = new Spot();
        $spot->setTitle($data->title)
            ->setSlug($data->slug)
            ->setMain($data->main)
            ->setCreator($this->security->getUser());

        foreach ($data->categories as $category) {
            $spot->addCategory($this->categoryRepository->find($category));
        }

        return $spot;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Spot) {
            return false;
        }

        return Spot::class === $to && null !== ($context['input']['class'] ?? null);
    }
}