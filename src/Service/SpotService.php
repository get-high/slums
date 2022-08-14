<?php

namespace App\Service;

use App\Repository\SpotRepository;

class SpotService
{
    private SpotRepository $spotRepository;

    public function __construct(SpotRepository $spotRepository)
    {
        $this->spotRepository = $spotRepository;
    }

    public function getAllMainSpots()
    {
        return $this->spotRepository->findBy(['main' => true]);
    }

    public function getLatesPublishedSpots(int $num)
    {
        return $this->spotRepository->getLatestPublished($num);
    }
}