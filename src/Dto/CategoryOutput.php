<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryOutput
{
    #[Groups("category:item:get")]
    public int $id;

    #[Groups("category:item:get")]
    public string $title;

    #[Groups("category:item:get")]
    public string $slug;

    #[Groups("category:item:get")]
    public bool $main;

    public static function createFromEntity(Category $category): self
    {
        $output = new CategoryOutput();
        $output->id = $category->getId();
        $output->title = $category->getTitle();
        $output->slug = $category->getSlug();
        $output->main = $category->isMain();

        return $output;
    }
}