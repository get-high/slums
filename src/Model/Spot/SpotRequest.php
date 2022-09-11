<?php

namespace App\Model\Spot;

use App\Validator\ValidCategory;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SpotRequest
{
    #[NotBlank]
    public string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    public string $slug;

    #[NotBlank]
    public bool $main;

    /**
     * @var int[]
     */
    #[NotBlank]
    #[ValidCategory]
    public array $categories;
}