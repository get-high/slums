<?php

namespace App\Dto\Spot;

use App\Validator\ValidCategory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class UpdateSpot
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
    #[NotBlank]
    #[NotNull]
    #[ValidCategory]
    #[Groups(["spot:write"])]
    public ?array $categories;

    #[Image(
        mimeTypes: ['image/jpeg'],
        minWidth: 700,
        minHeight: 500,
    )]
    #[Groups(['spot:write'])]
    public ?UploadedFile $image;
}