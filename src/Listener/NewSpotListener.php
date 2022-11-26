<?php

namespace App\Listener;

use App\Entity\Spot;
use App\Service\ImageUploader;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;

class NewSpotListener
{
    public function __construct(
        private ImageUploader $spotUploader,
    ) {}

    public function uploadDefaultImage(Spot $spot, LifecycleEventArgs $event): void
    {
        $this->spotUploader->uploadImage(new File(dirname(__DIR__, 2) . '/public/images/background.jpg'), $spot);
    }
}