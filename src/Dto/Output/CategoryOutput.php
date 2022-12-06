<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryOutput
{
    #[Groups(["category:item:get", "category:collection:get"])]
    public int $id;

    #[Groups(["category:item:get", "category:collection:get"])]
    public string $title;

    #[Groups("category:item:get")]
    public string $slug;

    #[Groups("category:item:get")]
    public string $description;

    #[Groups("category:collection:get")]
    public int $order_by;

    #[Groups(["category:item:get", "category:collection:get"])]
    public bool $main;

    public static function createFromEntity(Category $category): self
    {
        $output = new CategoryOutput();
        $output->id = $category->getId();
        $output->title = $category->getTitle();
        $output->slug = $category->getSlug();
        $output->description = $category->getDescription();
        $output->order_by = $category->getOrderBy();
        $output->main = $category->isMain();

        return $output;
    }
}