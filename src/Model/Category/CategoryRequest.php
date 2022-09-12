<?php

namespace App\Model\Category;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CategoryRequest
{
    #[NotBlank]
    public string $title;

    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    public string $slug;

    #[NotBlank]
    public bool $main;
}