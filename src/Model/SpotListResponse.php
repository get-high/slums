<?php

namespace App\Model;

class SpotListResponse
{
    /**
     * @var SpotListItem[]
     */
    private array $items;

    /**
     * @param SpotListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return SpotListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}