<?php

namespace App\Dto;

use App\Entity\Spot;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class SpotOutput
{
    #[Groups("spot:read")]
    public int $id;

    #[Groups("spot:read")]
    public string $title;

    #[Groups("spot:read")]
    public string $slug;

    #[Groups("spot:read")]
    public bool $main;

    #[Groups("spot:read")]
    public iterable $categories;

    public static function createFromEntity(Spot $spot): self
    {
        $output = new SpotOutput();
        $output->id = $spot->getId();
        $output->title = $spot->getTitle();
        $output->slug = $spot->getSlug();
        $output->main = $spot->isMain();
        $output->categories = $spot->getCategories();

        return $output;
    }
}