<?php

namespace App\Entity;

use App\Repository\SpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'spots')]
#[ORM\Entity(repositoryClass: SpotRepository::class)]
class Spot
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups('main')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('main')]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups('main')]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('main')]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('main')]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('main')]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('main')]
    private ?string $how_to_get = null;

    #[ORM\Column(nullable: true)]
    #[Groups('main')]
    private ?float $rating = null;

    #[ORM\Column(nullable: true)]
    #[Groups('main')]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    #[Groups('main')]
    private ?float $lng = null;

    #[ORM\Column(options: ['unsigned' => true, 'default' => 0])]
    #[Groups('main')]
    private ?bool $main = null;

    #[ORM\Column(nullable: true)]
    #[Groups('main')]
    private ?int $views = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('main')]
    private ?string $years = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('main')]
    private ?string $authors = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('main')]
    private ?\DateTimeInterface $published_at = null;

    #[ORM\ManyToOne(inversedBy: 'spots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('main')]
    private ?User $creator = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'spots')]
    private Collection $category;

    #[ORM\OneToMany(mappedBy: 'spot', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'spot', targetEntity: Photo::class, orphanRemoval: true)]
    private Collection $photos;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->photos = new ArrayCollection();
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
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

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
}
