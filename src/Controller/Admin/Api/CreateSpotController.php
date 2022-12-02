<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\SpotInput;
use App\Dto\SpotOutput;
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
        $input = new SpotInput();
        $dto = $input->createFromRequest($request);
        $this->validator->validate($dto, ['groups' => ['spot:write']]);

        $spot = (new Spot())
            ->setTitle($dto->title)
            ->setSlug($dto->slug)
            ->setMain($dto->main)
            ->setAddress($dto->address)
            ->setDescription($dto->description)
            ->setContent($dto->content)
            ->setHowToGet($dto->how_to_get)
            ->setLat($dto->lat)
            ->setLng($dto->lng)
            ->setMain($dto->main)
            ->setYears($dto->years)
            ->setAuthors($dto->authors)
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