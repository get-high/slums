<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\Spot;
use App\Repository\PhotoRepository;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PhotoController extends AbstractController
{
    private ImageUploader $photoUploader;

    private SpotRepository $spotRepository;

    private PhotoRepository $photoRepository;

    public function __construct(ImageUploader $photoUploader, SpotRepository $spotRepository, PhotoRepository $photoRepository)
    {
        $this->photoUploader = $photoUploader;
        $this->spotRepository = $spotRepository;
        $this->photoRepository = $photoRepository;
    }

    #[Route("admin/spots/{id<\d+>}/photos", name: "admin_spot_photos", methods: ["GET"])]
    public function photos(Spot $spot, Request $request)
    {

    }

    #[Route("admin/photos/{id<\d+>}/destroy", name: "admin_destroy_spot_photo", methods: ["GET", "DELETE"])]
    public function destroy(Photo $photo)
    {

    }
}
