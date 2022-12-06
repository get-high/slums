<?php

namespace App\Controller\Api\Admin;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\Input\SpotInput;
use App\Dto\Output\SpotOutput;
use App\Entity\Spot;
use App\Repository\CategoryRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UpdateSpotController extends AbstractController
{
    public function __construct(
        private ImageUploader $spotUploader,
        private ValidatorInterface $validator,
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Spot $spot, Request $request)
    {
        $input = new SpotInput();
        $dto = $input->createFromRequest($request);
        $this->validator->validate($dto, ['groups' => ['spot:update']]);

        $spot->setTitle($dto->title)
            ->setSlug($dto->slug)
            ->setAddress($dto->address)
            ->setDescription($dto->description)
            ->setContent($dto->content)
            ->setHowToGet($dto->how_to_get)
            ->setLat($dto->lat)
            ->setLng($dto->lng)
            ->setMain($dto->main)
            ->setYears($dto->years)
            ->setAuthors($dto->authors);

        foreach ($spot->getCategories() as $category) {
            $spot->removeCategory($category);
        }

        foreach ($dto->categories as $category) {
            $spot->addCategory($this->categoryRepository->find($category));
        }

        $this->validator->validate($spot);
        $this->em->persist($spot);
        $this->em->flush();
        $output = new SpotOutput();

        if ($dto->image) {
            $this->spotUploader->uploadImage($dto->image, $spot);
        }

        return $output->createFromEntity($spot);
    }
}