<?php

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Spot;
use Symfony\Component\Serializer\Annotation\Groups;

class SpotOutput
{
    #[Groups(["spot:read", "spot:item:get"])]
    public int $id;

    #[Groups(["spot:read", "spot:item:get"])]
    public string $title;

    #[Groups(["spot:read", "spot:item:get"])]
    public string $slug;

    #[Groups(["spot:read", "spot:item:get"])]
    public bool $main;

    /**
     * @var Category[]
     */
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