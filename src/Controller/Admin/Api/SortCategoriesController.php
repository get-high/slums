<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\SpotInput;
use App\Dto\SpotOutput;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SortCategoriesController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $em)
    {}

    public function __invoke(Request $request)
    {
        $input = new SpotInput();
        $dto = $input->createFromRequest($request);
        $this->validator->validate($dto, ['groups' => ['spot:update']]);

        $spot = new Category();
        $spot->setOrderBy($dto->title);

        $this->validator->validate($spot);
        $this->em->persist($spot);
        $this->em->flush();
        $output = new SpotOutput();

        return $output->createFromEntity($spot);
    }
}