<?php

namespace App\Dto;

use App\Validator\ValidPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class PhotoInput
{
    /**
     * @var int[]
     */
    #[NotBlank(groups: ["photo:sort"])]
    #[NotNull(groups: ["photo:sort"])]
    #[ValidPhoto(groups: ["photo:sort"])]
    public ?array $photos;

    #[NotBlank(groups: ["photo:image"])]
    #[Image(
        mimeTypes: ["image/jpeg"],
        minWidth: 700,
        minHeight: 500,
        groups: ["photo:image"]
    )]
    public ?UploadedFile $image;
}