<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\PhotoInput;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SortPhotosController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private PhotoRepository $repository,
        private EntityManagerInterface $em,
    )
    {}

    public function __invoke(Request $request): void
    {
        $dto = new PhotoInput();
        $dto->photos = $request->get('photos');
        $this->validator->validate($dto, ['groups' => ['photo:sort']]);

        foreach ($dto->photos as $index => $id) {
            $photo = $this->repository->find($id);
            $photo->setOrderBy($index);
            $this->em->persist($photo);
            $this->em->flush();
        }
    }
}