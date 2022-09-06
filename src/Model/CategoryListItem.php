<?php

namespace App\Model;

class CategoryListItem
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isMain(): bool
    {
        return $this->main;
    }
}