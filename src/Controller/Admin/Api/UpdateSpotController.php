<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\Spot\SpotOutput;
use App\Dto\Spot\UpdateSpot;
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
        $dto = new UpdateSpot();
        $dto->title = $request->get('title');
        $dto->slug = $request->get('slug');
        $dto->main = $request->get('main');
        $dto->image = $request->files->get('image');

        foreach ($request->get('categories') as $category) {
            $dto->categories[] = $category;
        }

        $this->validator->validate($dto);

        $spot->setTitle($dto->title)
            ->setSlug($dto->slug)
            ->setMain($dto->main);

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