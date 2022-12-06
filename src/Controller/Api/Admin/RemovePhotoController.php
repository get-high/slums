<?php

namespace App\Controller\Api\Admin;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;

class RemovePhotoController
{
    public function __construct(
        private Filesystem $photoFilesystem,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Photo $photo)
    {
        $this->photoFilesystem->delete($photo->getId() . '.jpg');
        $this->photoFilesystem->delete($photo->getId() . '-medium.jpg');
        $this->photoFilesystem->delete($photo->getId() . '-preview.jpg');
        $this->em->remove($photo);
        $this->em->flush();
    }
}