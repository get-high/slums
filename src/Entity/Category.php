<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Admin\Api\CreateSpotController;
use App\Dto\CategoryInput;
use App\Dto\CategoryOutput;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Table(name: "categories")]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(fields: ["slug"], message: "Данный slug уже используется в системе.")]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "normalization_context" => ["groups" => ["category:collection:get"]],
        ],
        "post",
    ],
    itemOperations: [
        "get",
        "patch",
        "delete",
        "sort" => [
            'path' => '/categories/sort',
            'method' => "post",
            'controller' => CreateSpotController::class,
            'openapi_context' => [
                'summary' => 'Sort Categories',
                'description' => 'Sort Categories',
            ],
        ],
    ],
    denormalizationContext: ["groups" => ["category:write"]],
    input: CategoryInput::class,
    normalizationContext: ["groups" => ["category:item:get"]],
    output: CategoryOutput::class,
    paginationEnabled: false,
    security: "is_granted('ROLE_ADMIN')",
)]
class Category
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[NotBlank]
    private ?string $slug = null;

    #[ORM\Column(options: ["unsigned" => true, "default" => 0])]
    private ?int $order_by = 0;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[NotBlank]
    private ?string $description = null;

    #[ORM\Column(options: ["unsigned" => true, "default" => 0])]
    #[NotNull]
    private ?bool $main = null;

    #[ORM\ManyToMany(targetEntity: Spot::class, mappedBy: "categories")]
    private Collection $spots;

    public function __construct()
    {
        $this->spots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function isMain(): ?bool
    {
        return $this->main;
    }

    public function setMain(bool $main): self
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return Collection<int, Spot>
     */
    public function getSpots(): Collection
    {
        return $this->spots;
    }

    public function addSpot(Spot $spot): self
    {
        if (!$this->spots->contains($spot)) {
            $this->spots[] = $spot;
            $spot->addCategory($this);
        }

        return $this;
    }

    public function removeSpot(Spot $spot): self
    {
        if ($this->spots->removeElement($spot)) {
            $spot->removeCategory($this);
        }

        return $this;
    }
}
