<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\Spot\CreateSpot;
use App\Dto\Spot\SpotOutput;
use App\Entity\Spot;
use App\Repository\CategoryRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;

#[AsController]
class CreateSpotController extends AbstractController
{
    public function __construct(
        private ImageUploader $spotUploader,
        private ValidatorInterface $validator,
        private CategoryRepository $categoryRepository,
        private Security $security,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Request $request)
    {
        $dto = new CreateSpot();
        $dto->title = $request->get('title');
        $dto->slug = $request->get('slug');
        $dto->main = $request->get('main');
        $dto->image = $request->files->get('image');

        foreach ($request->get('categories') as $category) {
            $dto->categories[] = $category;
        }

        $this->validator->validate($dto);

        $spot = (new Spot())
            ->setTitle($dto->title)
            ->setSlug($dto->slug)
            ->setMain($dto->main)
            ->setCreator($this->security->getUser());

        foreach ($dto->categories as $category) {
            $spot->addCategory($this->categoryRepository->find($category));
        }

        $this->validator->validate($spot);
        $this->em->persist($spot);
        $this->em->flush();
        $this->spotUploader->uploadImage($dto->image, $spot);
        $output = new SpotOutput();

        return $output->createFromEntity($spot);
    }
}