<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class PhotoInput
{
    #[NotBlank]
    #[Groups(["photo:write"])]
    public string $description;

    #[Groups("photo:write")]
    public int $order_by;

    #[NotBlank(groups: ["photo:image"])]
    #[Image(
        mimeTypes: ["image/jpeg"],
        minWidth: 700,
        minHeight: 500,
        groups: ["photo:image"]
    )]
    public ?UploadedFile $image = null;
}