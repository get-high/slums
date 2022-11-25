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

    #[Groups(["spot:read"])]
    public ?string $address;

    #[Groups("spot:read")]
    public ?string $description;

    #[Groups("spot:read")]
    public ?string $content;

    #[Groups("spot:read")]
    public ?string $how_to_get;

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
        $output->address = $spot->getAddress();
        $output->description = $spot->getDescription();
        $output->content = $spot->getContent();
        $output->how_to_get = $spot->getHowToGet();
        $output->main = $spot->isMain();
        $output->categories = $spot->getCategories();

        return $output;
    }
}