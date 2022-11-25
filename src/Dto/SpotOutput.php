<?php

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Spot;
use Symfony\Component\Serializer\Annotation\Groups;

class SpotOutput
{
    #[Groups(["spot:item:get", "spot:collection:get"])]
    public int $id;

    #[Groups(["spot:item:get", "spot:collection:get"])]
    public string $title;

    #[Groups(["spot:item:get", "spot:collection:get"])]
    public string $slug;

    #[Groups("spot:item:get")]
    public ?string $address;

    #[Groups("spot:item:get")]
    public ?string $description;

    #[Groups("spot:item:get")]
    public ?string $content;

    #[Groups("spot:item:get")]
    public ?string $how_to_get;

    #[Groups(["spot:item:get", "spot:collection:get"])]
    public bool $main;

    /**
     * @var Category[]
     */
    #[Groups("spot:item:get")]
    public iterable $categories;

    public static function createFromEntity(Spot $spot): self
    {
        $output = new SpotOutput();
        $output->id = $spot->getId();
        $output->title = $spot->getTitle();
        $output->slug = $spot->getSlug();
        $output->address = $spot->getAddress();
        $output->description = $spot->getDescription();
        $output->content = $spot->getContent();
        $output->how_to_get = $spot->getHowToGet();
        $output->main = $spot->isMain();
        $output->categories = $spot->getCategories();

        return $output;
    }
}