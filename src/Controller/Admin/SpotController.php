<?php

namespace App\Controller\Admin;

use App\Entity\Spot;
use App\Form\Model\SpotFormModel;
use App\Form\SpotFormType;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SpotController extends AbstractController
{
    private ImageUploader $spotUploader;

    private SpotRepository $repository;

    public function __construct(ImageUploader $spotUploader, SpotRepository $repository)
    {
        $this->spotUploader = $spotUploader;
        $this->repository = $repository;
    }

    #[Route("admin/spots", name: "admin_spots", methods: ["GET"])]
    public function index()
    {
        $spots = $this->repository->findAll();

        return $this->render(
            'admin/spots/spots.html.twig', [
            'spots' => $spots,
        ]);
    }

    #[Route("admin/spots/create", name: "admin_create_spot")]
    public function create(Request $request)
    {
        $form = $this->createForm(SpotFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spot = $form->getData();
            $user = $this->getUser();

            /**
             * @var UploadedFile|null $image
             */
            $image = $form->get('image')->getData();

            //$spot = new Spot();

            $spot
                ->setCreator($user)
                ->setPublishedAt(new \DateTime())
            ;

            foreach ($spot->getCategories() as $category) {
                $spot->addCategory($category);
            }

            $spot = $this->repository->add($spot, true);

            $this->spotUploader->uploadImage($image, $spot);

            $this->addFlash('message', 'Объект успешно добавлен');

            return $this->redirectToRoute('admin_edit_spot', ['id' => $spot->getId()]);
        }

        return $this->render(
            'admin/spots/create.html.twig', [
                'CreateSpotForm' => $form->createView(),
            ]);
    }

    #[Route("admin/spots/{id<\d+>}/edit", name: "admin_edit_spot")]
    public function edit(Spot $spot, Request $request)
    {
        $form = $this->createForm(SpotFormType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spot = $form->getData();

            /**
             * @var UploadedFile|null $image
             */
            $image = $form->get('image')->getData();

          /*  $spot
                ->setTitle($spotModel->title)
                ->setSlug($spotModel->slug)
                ->setDescription($spotModel->description)
                ->setMain($spotModel->main)
                //->setCreator($user)
                //->setPublishedAt(new \DateTime())
            ;*/

            foreach ($spot->getCategories() as $category) {
                $spot->addCategory($category);
            }

            $spot = $this->repository->add($spot, true);

            //$this->spotUploader->uploadImage($image, $spot);

            $this->addFlash('message', 'Объект успешно изменен');

            return $this->redirectToRoute('admin_edit_spot', ['id' => $spot->getId()]);
        }

        //dd($form->createView());

        return $this->render(
            'admin/spots/edit.html.twig', [
            'EditSpotForm' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    #[Route("admin/spots/{id<\d+>}", name: "admin_destroy_spot", methods: ["DELETE"])]
    public function destroy(Spot $spot, SpotRepository $repository)
    {

    }

    private function handleFormRequest(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spot = $form->getData();

            $this->repository->add($spot, true);

            return $spot;
        }

        return null;
    }
}
