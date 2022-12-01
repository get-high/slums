<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Admin\Api\CreateSpot;
use App\Controller\Admin\Api\RemoveSpot;
use App\Controller\Admin\Api\UpdateSpot;
use App\Dto\SpotInput;
use App\Dto\SpotOutput;
use App\Repository\SpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table(name: "spots")]
#[ORM\Entity(repositoryClass: SpotRepository::class)]
#[UniqueEntity(fields: ["slug"], message: "Данный slug уже используется в системе.")]
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => [
            "controller" => CreateSpot::class,
            "normalization_context" => ["skip_null_values" => false, "groups" => ["spot:write", "spot:item:get"]],
            "denormalization_context" => ["groups" => ["spot:write", "spot:collection:post", "spot:item:get"]],
            "input" => SpotInput::class,
            "output" => SpotOutput::class,
            "deserialize" => false,
        ],
    ],
    itemOperations: [
        "get" => [
            "normalization_context" => ["skip_null_values" => false, "groups" => ["spot:item:get"]],
        ],
        "delete" => [
            "controller" => RemoveSpot::class,
        ],
        "update" => [
            "path" => "/spots/{id}",
            "method" => "post",
            "controller" => UpdateSpot::class,
            "normalization_context" => ["skip_null_values" => false, "groups" => ["spot:write"]],
            "denormalization_context" => ["groups" => ["spot:write", "spot:collection:post", "spot:item:get"]],
            "input" => SpotInput::class,
            "output" => SpotOutput::class,
            "deserialize" => false,
        ],
    ],
    denormalizationContext: ["groups" => ["spot:write", "spot:collection:post"]],
    normalizationContext: ["groups" => ["spot:collection:get"]],
    output: SpotOutput::class,
    paginationEnabled: true,
    paginationItemsPerPage: 10,
    security: "is_granted('ROLE_ADMIN')",
)]
class Spot
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(["spot:write"])]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups(["spot:write"])]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[NotBlank]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр")]
    #[Groups(["spot:write"])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["spot:write"])]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["spot:write"])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $how_to_get = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "float")]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "float")]
    private ?float $lng = null;

    #[ORM\Column(options: ["unsigned" => true, "default" => 0])]
    #[NotNull]
    #[Groups(["spot:write"])]
    private ?bool $main = null;

    #[ORM\Column(nullable: true)]
    private ?int $views = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $years = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authors = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $published_at = null;

    #[ORM\ManyToOne(inversedBy: "spots")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "spots")]
    #[NotBlank]
    #[Groups(["spot:write"])]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: "spot", targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: "spot", targetEntity: Photo::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: "spot", targetEntity: Vote::class, orphanRemoval: true)]
    private Collection $votes;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: "spots_user_was")]
    #[ORM\JoinTable(name: "spot_user_was")]
    private Collection $user_was;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: "spots_user_will")]
    #[ORM\JoinTable(name: "spot_user_will")]
    private Collection $user_will;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->user_was = new ArrayCollection();
        $this->user_will = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getHowToGet(): ?string
    {
        return $this->how_to_get;
    }

    public function setHowToGet(?string $how_to_get): self
    {
        $this->how_to_get = $how_to_get;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

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

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getYears(): ?string
    {
        return $this->years;
    }

    public function setYears(?string $years): self
    {
        $this->years = $years;

        return $this;
    }

    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    public function setAuthors(?string $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(?\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setSpot($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getSpot() === $this) {
                $comment->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setSpot($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getSpot() === $this) {
                $photo->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setSpot($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getSpot() === $this) {
                $vote->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserWas(): Collection
    {
        return $this->user_was;
    }

    public function addUserWas(User $userWas): self
    {
        if (!$this->user_was->contains($userWas)) {
            $this->user_was->add($userWas);
        }

        return $this;
    }

    public function removeUserWas(User $userWas): self
    {
        $this->user_was->removeElement($userWas);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserWill(): Collection
    {
        return $this->user_will;
    }

    public function addUserWill(User $userWill): self
    {
        if (!$this->user_will->contains($userWill)) {
            $this->user_will->add($userWill);
        }

        return $this;
    }

    public function removeUserWill(User $userWill): self
    {
        $this->user_will->removeElement($userWill);

        return $this;
    }
}
