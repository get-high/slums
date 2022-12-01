<?php

namespace App\Controller\Admin\Api;

use App\Entity\Spot;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class RemoveSpot
{
    public function __construct(
        private Filesystem $spotFilesystem,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Spot $spot)
    {
        if ($spot->getPhotos()->count()) {
            return new JsonResponse(['error' => 'Данный spot невозмождно удалить, пока он содержит фотографии'], 400);
        }

        $this->spotFilesystem->delete($spot->getId() . '.jpg');
        $this->spotFilesystem->delete($spot->getId() . '-medium.jpg');
        $this->spotFilesystem->delete($spot->getId() . '-preview.jpg');

        $this->em->remove($spot);
        $this->em->flush();
    }
}