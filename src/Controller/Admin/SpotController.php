<?php

namespace App\Controller\Admin;

use App\Entity\Spot;
use App\Form\CreateSpotFormType;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SpotController extends AbstractController
{
    private ImageUploader $spotUploader;

    public function __construct(ImageUploader $spotUploader)
    {
        $this->spotUploader = $spotUploader;
    }

    #[Route("admin/spots", name: "admin_spots", methods: ["GET"])]
    public function index(SpotRepository $repository): JsonResponse
    {

    }

    #[Route("admin/spots/create", name: "admin_create_spot")]
    public function create(Request $request, SpotRepository $repository)
    {
        $form = $this->createForm(CreateSpotFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spotModel = $form->getData();
            $user = $this->getUser();

            /**
             * @var UploadedFile|null $image
             */
            $image = $form->get('image')->getData();

            $spot = new Spot();

            $spot
                ->setTitle($spotModel->title)
                ->setSlug($spotModel->slug)
                ->setDescription($spotModel->description)
                ->setMain($spotModel->main)
                ->setCreator($user)
                ->setPublishedAt(new \DateTime())
            ;

            $spot = $repository->add($spot, true);

            $this->spotUploader->uploadImage($image, $spot);
        }

        return $this->render(
            'admin/spots/create.html.twig', [
                'CreateSpotForm' => $form->createView(),
            ]);
    }

    #[Route("admin/spots", name: "admin_store_spot", methods: ["POST"])]
    public function store(SpotRepository $repository): JsonResponse
    {

    }

    #[Route("admin/spots/{id<\d+>}", name: "admin_show_spot", methods: ["GET"])]
    public function show(Spot $spot, SpotRepository $repository): JsonResponse
    {

    }

    #[Route("admin/spots/{id<\d+>}/edit", name: "admin_edit_spot", methods: ["GET"])]
    public function edit(Spot $spot, SpotRepository $repository): JsonResponse
    {

    }

    #[Route("admin/spots/{id<\d+>}", name: 'admin_update_spot', methods: ["PUT", "PATCH"])]
    public function update(Spot $spot, SpotRepository $repository): JsonResponse
    {

    }

    #[Route("admin/spots/{id<\d+>}", name: "admin_destroy_spot", methods: ["DELETE"])]
    public function destroy(Spot $spot, SpotRepository $repository): JsonResponse
    {

    }
}
