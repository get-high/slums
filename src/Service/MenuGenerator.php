<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class MenuGenerator
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function topMenu()
    {
        return $this->categoryRepository->findBy(['main' => true]);
    }

    public function bottomMenu()
    {
        return $this->categoryRepository->findBy(['main' => false]);
    }
}