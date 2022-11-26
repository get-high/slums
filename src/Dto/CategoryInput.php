<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CategoryInput
{
    #[Groups("category:write")]
    #[NotBlank]
    public string $title;

    #[Groups("category:write")]
    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    public string $slug;

    #[Groups("category:write")]
    #[NotBlank]
    public bool $main;

    public static function createFromEntity(?Category $category): self
    {
        $dto = new CategoryInput();

        if (!$category) {
            return $dto;
        }

        $dto->title = $category->getTitle();
        $dto->slug = $category->getSlug();
        $dto->main = $category->isMain();

        return $dto;
    }

    public function createOrUpdateEntity(?Category $category): Category
    {
        if (!$category) {
            $category = new Category();
        }

        $category->setTitle($this->title);
        $category->setSlug($this->slug);
        $category->setMain($this->main);

        return $category;
    }
}