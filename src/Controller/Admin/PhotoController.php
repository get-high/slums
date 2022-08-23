<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\Spot;
use App\Repository\PhotoRepository;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use League\Flysystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PhotoController extends AbstractController
{
    private ImageUploader $photoUploader;

    private SpotRepository $spotRepository;

    private PhotoRepository $photoRepository;

    private Filesystem $photoFilesystem;

    public function __construct(ImageUploader $photoUploader, SpotRepository $spotRepository, PhotoRepository $photoRepository, Filesystem $photoFilesystem)
    {
        $this->photoUploader = $photoUploader;
        $this->spotRepository = $spotRepository;
        $this->photoRepository = $photoRepository;
        $this->photoFilesystem = $photoFilesystem;
    }

    #[Route("admin/spots/{id<\d+>}/photos", name: "admin_spot_photos", methods: ["GET"])]
    public function photos(Spot $spot)
    {
        $photos = $this->photoRepository->findBy(['spot' => $spot], ['order_by' => 'ASC']);

        return $this->render(
            'admin/photos/photos.html.twig', [
            'spot' => $spot,
            'photos' => $photos,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route("admin/photos/sort", name: "admin_spot_photos_sort", methods: ["POST"])]
    public function sort(Request $request): Response
    {
        $i = 0;

        foreach ($request->get('item') as $item) {
            $photo = $this->photoRepository->find($item);
            $photo->setOrderBy($i);
            $this->photoRepository->add($photo, true);
            $i++;
        }

        return new Response();
    }

    #[Route("admin/photos/{id<\d+>}/destroy", name: "admin_destroy_spot_photo", methods: ["GET", "DELETE"])]
    public function destroy(Photo $photo)
    {
        $this->photoFilesystem->delete($photo->getId() . '.jpg');
        $this->photoFilesystem->delete($photo->getId() . '-medium.jpg');
        $this->photoFilesystem->delete($photo->getId() . '-preview.jpg');

        $this->photoRepository->remove($photo, true);

        $this->addFlash('message', 'Фото успешно удалено');

        return $this->redirectToRoute('admin_spot_photos', ['id' => $photo->getSpot()->getId()]);
    }
}
