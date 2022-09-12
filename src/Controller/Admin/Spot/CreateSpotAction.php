<?php

namespace App\Controller\Admin\Spot;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Encoder\MultipartDecoder;
use App\Entity\Spot;
use App\Model\Spot\SpotRequest;
use App\Repository\CategoryRepository;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class CreateSpotAction
{
    public function __construct(
        private ImageUploader $spotUploader,
        private SpotRepository $spotRepository,
        private CategoryRepository $categoryRepository,
        private ValidatorInterface $validator,
        private Security $security,
        private MultipartDecoder $decoder,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Request $request)
    {
        $data = $this->decoder->decode($request, 'multipart', []);

        $model = new SpotRequest(
            $data['title'],
            $data['slug'],
            $data['main'],
            array_map('intval', explode(',', $data['categories'])),
            $data['image']);

        $this->validator->validate($model);

        $spot = (new Spot())
            ->setTitle($model->getTitle())
            ->setSlug($model->getSlug())
            ->setMain($model->isMain())
            ->setCreator($this->security->getUser());

        foreach ($model->getCategories() as $category) {
            $spot->addCategory($this->categoryRepository->find($category));
        }

        $this->validator->validate($spot);
        $this->em->persist($spot);
        $this->em->flush();

        $this->spotUploader->uploadImage($request->files->get('image'), $spot);

        return $spot;
    }
}