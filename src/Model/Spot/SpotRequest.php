<?php

namespace App\Model\Spot;

use App\Validator\ValidCategory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SpotRequest
{
    #[NotBlank]
    private string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    private string $slug;

    #[NotBlank]
    private bool $main;

    /**
     * @var int[]
     */
    #[NotBlank]
    private array $categories;

    #[NotBlank]
    #[Image(
        mimeTypes: ['image/jpeg'],
        minWidth: 700,
        minHeight: 500,
    )]
    private UploadedFile $image;

    /**
     * SpotRequest constructor.
     * @param string $title
     * @param string $slug
     * @param bool $main
     * @param int[] $categories
     * @param UploadedFile $image
     */
    public function __construct(string $title, string $slug, bool $main, array $categories, UploadedFile $image)
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->main = $main;
        $this->categories = $categories;
        $this->image = $image;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getImage(): UploadedFile
    {
        return $this->image;
    }
}