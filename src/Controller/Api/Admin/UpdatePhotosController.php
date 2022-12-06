<?php

namespace App\Controller\Api\Admin;

use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UpdatePhotosController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PhotoRepository $repository,
    ) {}

    public function __invoke(Request $request): void
    {
        foreach ($request->get('photos') as $id => $description) {
            if ($photo = $this->repository->find($id)) {
                $photo->setDescription($description);
                $this->em->persist($photo);
                $this->em->flush();
            }
        }
    }
}