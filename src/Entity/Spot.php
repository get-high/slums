<?php

namespace App\Entity;

use App\Repository\SpotRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'spots')]
#[ORM\Entity(repositoryClass: SpotRepository::class)]
class Spot
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $how_to_get = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    private ?float $lng = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_main = null;

    #[ORM\Column(nullable: true)]
    private ?int $views = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $years = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authors = null;

    #[ORM\Column(nullable: true)]
    private ?int $style = null;

    #[ORM\Column(nullable: true)]
    private ?int $security_level = null;

    #[ORM\Column]
    private ?int $published_by = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $published_at = null;

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

    public function isIsMain(): ?bool
    {
        return $this->is_main;
    }

    public function setIsMain(?bool $is_main): self
    {
        $this->is_main = $is_main;

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

    public function getStyle(): ?int
    {
        return $this->style;
    }

    public function setStyle(?int $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getSecurityLevel(): ?int
    {
        return $this->security_level;
    }

    public function setSecurityLevel(?int $security_level): self
    {
        $this->security_level = $security_level;

        return $this;
    }

    public function getPublishedBy(): ?int
    {
        return $this->published_by;
    }

    public function setPublishedBy(int $published_by): self
    {
        $this->published_by = $published_by;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(?\DateTimeImmutable $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }
}
