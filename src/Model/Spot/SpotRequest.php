<?php

namespace App\Model\Spot;

use App\Validator\UniqueSpotSlug;
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
    #[UniqueSpotSlug]
    private string $slug;

    #[NotBlank]
    private bool $main;

    /**
     * @var int[]
     */
    #[NotBlank]
    #[ValidCategory]
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->main;
    }

    /**
     * @param bool $main
     */
    public function setMain(bool $main): void
    {
        $this->main = $main;
    }

    /**
     * @return int[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param int[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $image
     */
    public function setImage(UploadedFile $image): void
    {
        $this->image = $image;
    }
}