<?php

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Spot;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class SpotInput
{
    #[NotBlank]
    #[Groups(["spot:write", "user:write"])]
    public string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    #[Groups(["spot:write", "user:write"])]
    public string $slug;

    #[NotNull]
    #[Groups(["spot:write"])]
    public bool $main;

    /**
     * @var Category[]
     */
    #[NotBlank]
    #[Groups(["spot:write"])]
    public iterable $categories;

    public static function createFromEntity(?Spot $spot): self
    {
        $dto = new SpotInput();

        if (!$spot) {
            return $dto;
        }

        $dto->title = $spot->getTitle();
        $dto->slug = $spot->getSlug();
        $dto->main = $spot->isMain();
        $dto->categories = $spot->getCategories();

        return $dto;
    }

    public function createOrUpdateEntity(?Spot $spot, User $creator): Spot
    {
        if (!$spot) {
            $spot = new Spot();
            $spot->setCreator($creator);
        }

        $spot->setTitle($this->title);
        $spot->setSlug($this->slug);
        $spot->setMain($this->main);
        foreach ($spot->getCategories() as $category) {
            $spot->removeCategory($category);
        }
        foreach ($this->categories as $category) {
            $spot->addCategory($category);
        }

        return $spot;
    }
}