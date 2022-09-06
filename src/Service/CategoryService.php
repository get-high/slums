<?php

namespace App\Service;

use App\Entity\Category;
use App\Model\CategoryListItem;
use App\Model\CategoryListResponse;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Criteria;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(): CategoryListResponse
    {
        $categories = $this->categoryRepository->findBy([], ['title' => Criteria::ASC]);

        $items = array_map(
            fn (Category $category) => new CategoryListItem(
                $category->getId(), $category->getTitle(), $category->getSlug(), $category->isMain()
            ),
            $categories
        );

        return new CategoryListResponse($items);
    }
}