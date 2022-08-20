<?php

namespace App\Form\Model;

use App\Validator\UniqueSpot;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSpotFormModel
{
    #[Assert\NotBlank(message: "Поле title не может быть пустым")]
    public $title;

    #[Assert\NotBlank(message: "Поле slug не может быть пустым")]
    #[Assert\Regex(pattern: "/^[a-z_0-9]+$/", message: "Поле slug может состоять только из латинских букв, _ и цифр")]
    #[UniqueSpot]
    public $slug;

    public $address;

    #[Assert\NotBlank(message: "Поле description не может быть пустым")]
    public $description;

    public $content;

    public $how_to_get;

    #[Assert\Type(type: "float")]
    public $lat;

    #[Assert\Type(type: "float")]
    public $lng;

    public $main;

    public $years;

    public $authors;

    public $image;

    public $categories;
}