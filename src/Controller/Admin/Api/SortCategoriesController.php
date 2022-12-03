<?php

namespace App\Controller\Admin\Api;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\CategorySort;
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
        private EntityManagerInterface $em,
    )
    {}

    public function __invoke(Request $request): void
    {
        $dto = new CategorySort();
        $dto->categories = $request->get('categories');
        $this->validator->validate($dto);

        foreach ($dto->categories as $index => $cat) {
            $category = $this->categoryRepository->find($cat);
            $category->setOrderBy($index);
            $this->em->persist($category);
            $this->em->flush();
        }
    }
}