<?php

namespace App\Dto;

use App\Validator\ValidCategory;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CategorySort
{
    /**
     * @var int[]
     */
    #[NotNull]
    #[NotBlank]
    #[ValidCategory]
    #[Groups(["category:sort"])]
    public ?array $categories;
}