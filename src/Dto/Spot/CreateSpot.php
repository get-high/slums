<?php

namespace App\Dto\Spot;

use App\Entity\Spot;
use App\Entity\User;
use App\Validator\ValidCategory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class CreateSpot
{
    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    #[Groups(["spot:write"])]
    public ?string $slug;

    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?string $address;

    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?string $description;

    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?string $content;

    #[Groups(["spot:write"])]
    public ?string $how_to_get;

    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?float $lat;

    #[NotBlank]
    #[Groups(["spot:write"])]
    public ?float $lng;

    #[NotNull]
    #[Groups(["spot:write"])]
    public ?bool $main;

    #[Groups(["spot:write"])]
    public ?string $years;

    #[Groups(["spot:write"])]
    public ?string $authors;

    /**
     * @var int[]
     */
    #[NotNull]
    #[NotBlank]
    #[ValidCategory]
    #[Groups(["spot:write"])]
    public ?array $categories;

    #[NotBlank]
    #[Image(
        mimeTypes: ['image/jpeg'],
        minWidth: 700,
        minHeight: 500,
    )]
    #[Groups(['spot:write'])]
    public ?UploadedFile $image;

    public static function createFromEntity(?Spot $spot): self
    {
        $dto = new CreateSpot();

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