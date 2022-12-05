<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Admin\Api\UpdateSpotPhotosController;
use App\Dto\PhotoOutput;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'photos')]
#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
        "update" => [
            "path" => "/photos/update",
            "method" => "post",
            "controller" => UpdateSpotPhotosController::class,
            "normalization_context" => ["skip_null_values" => false, "groups" => ["photo:item:get"]],
            "validation_context" => ["groups" => ["photo:update"]],
            #"input" => SpotInput::class,
            #"output" => SpotOutput::class,
            "deserialize" => false,
            "input_formats" => ["multipart" => ["multipart/form-data"]],
            "openapi_context" => [
                "parameters" => [
                   # "name" => "spotId",
                    #"in" => "path",
                    #"type" => "string",

                ],
            ],
        ],
        "upload" => [
            "path" => "/photos/upload",
            "method" => "post",
            #"controller" => UpdateSpotController::class,

            "output" => false,
            "deserialize" => false,
            "input_formats" => ["multipart" => ["multipart/form-data"]],
            "openapi_context" => [
                "summary" => "Updates the Spot resource.",
                "description" => "Updates the Spot resource.",
                "responses" => ["201" => ["description" => "Spot resource updated"]],
                "requestBody" => [
                    "description" => "The updated Spot resource",
                    "required" => true,
                    "content" => [
                        "multipart/form-data" => [
                            "schema" => [
                                "type" => "object",
                                "properties" => [
                                    "spot" => [
                                        "type" => "string",
                                    ],
                                    "photos" => [
                                        "type" => "array",
                                        "format" => "binary",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        "sort" => [
            "path" => "/photos/sort",
            "method" => "post",
            #"controller" => SortCategoriesController::class,
            "denormalization_context" => ["groups" => ["photo:sort"]],
            #"input" => SpotInput::class,
            "output" => false,
            "deserialize" => false,
            "validate"=> false,
            "input_formats" => ["multipart" => ["multipart/form-data"]],
            "openapi_context" => [
                "summary" => "Sorts the collection of Category resources.",
                "description" => "Sorts the collection of Category resources.",
                "responses" => ["204" => ["description" => "Collection of Category resources was sorted"]],
                "requestBody" => [
                    "required" => true,
                    "content" => [
                        "multipart/form-data" => [
                            "schema" => [
                                "type" => "object",
                                "properties" => [
                                    "photos" => [
                                        "type" => "array",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    itemOperations: [
        "get",
        "delete",
    ],
    denormalizationContext: ["groups" => ["photo:write"]],
    normalizationContext: ["groups" => ["photo"]],
    output: PhotoOutput::class,
    paginationEnabled: false,
    security: "is_granted('ROLE_ADMIN')",
)]
#[ApiFilter(SearchFilter::class, properties: ['spot' => 'exact'])]
class Photo
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ["unsigned" => true, "default" => 0])]
    private ?int $order_by = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spot $spot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderBy(): ?int
    {
        return $this->order_by;
    }

    public function setOrderBy(?int $order_by): self
    {
        $this->order_by = $order_by;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }
}
