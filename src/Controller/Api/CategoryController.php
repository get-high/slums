<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    #[Route('/api/v1/categories', methods: ["GET"])]
    public function categories(): Response
    {
        return $this->json($this->categoryService->getCategories());
    }

    #[Route('/api/v1/categories/{id<\d+>}/edit', methods: ["GET"])]
    public function category(Category $category): Response
    {
        return $this->json($this->categoryService->getCategory($category));
    }
}