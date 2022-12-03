<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class CategoryInput
{
    #[NotBlank]
    #[Groups("category:write")]
    public ?string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    #[Groups("category:write")]
    public ?string $slug;

    #[NotBlank]
    #[Groups("category:write")]
    public ?string $description;

    #[NotNull]
    #[Groups("category:write")]
    public ?bool $main;

    public static function createFromEntity(?Category $category): self
    {
        $dto = new CategoryInput();

        if (!$category) {
            return $dto;
        }

        $dto->title = $category->getTitle();
        $dto->slug = $category->getSlug();
        $dto->description = $category->getDescription();
        $dto->main = $category->isMain();

        return $dto;
    }

    public function createOrUpdateEntity(?Category $category): Category
    {
        if (!$category) {
            $category = new Category();
        }

        $category->setTitle($this->title)
            ->setSlug($this->slug)
            ->setDescription($this->description)
            ->setMain($this->main);

        return $category;
    }
}