<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryOutput
{
    #[Groups("category:read")]
    public int $id;

    #[Groups("category:read")]
    public string $title;

    #[Groups("category:read")]
    public string $slug;

    #[Groups("category:read")]
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