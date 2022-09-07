<?php

namespace App\Model;

class SpotListItem
{
    private int $id;

    private string $title;

    private string $slug;

    private bool $main;

    public function __construct(int $id, string $title, string $slug, bool $main)
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->main = $main;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function setMain(bool $main): self
    {
        $this->main = $main;

        return $this;
    }
}