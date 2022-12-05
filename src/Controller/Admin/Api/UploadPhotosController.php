<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\PhotoInput;
use App\Dto\PhotoOutput;
use App\Entity\Photo;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UploadPhotosController extends AbstractController
{
    public function __construct(
        private ImageUploader $photoUploader,
        private ValidatorInterface $validator,
        private SpotRepository $spotRepository,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Request $request)
    {
        $spot = $this->spotRepository->find($request->get('spot'));

        if (!$spot) {
            return $this->json([
                'error' => 'Invalid Spot Id',
            ], 422);
        }

        foreach ($request->files->get('photos') as $photo) {
            $dto = new PhotoInput();
            $dto->image = $photo;
            $this->validator->validate($dto, ['groups' => ['photo:image']]);
        }

        $photo = (new Photo())->setSpot($spot);
        $this->em->persist($photo);
        $this->em->flush();

        foreach ($request->files->get('photos') as $image) {
            $this->photoUploader->uploadImage($image, $photo);
        }
    }
}