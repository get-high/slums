<?php

namespace App\EventListener;

use App\Entity\Vote;
use App\Repository\SpotRepository;
use App\Repository\VoteRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SpotRatingUpdateListener
{
    private VoteRepository $voteRepository;

    private SpotRepository $spotRepository;

    public function __construct(VoteRepository $voteRepository, SpotRepository $spotRepository)
    {
        $this->voteRepository = $voteRepository;
        $this->spotRepository = $spotRepository;
    }

    public function updateSpotRating(Vote $vote, LifecycleEventArgs $event): void
    {
        $votes = array_column($this->voteRepository->arraySpotVotes($vote), 'rating');
        $spot = $this->spotRepository->find($vote->getSpot());
        $spot->setRating(array_sum($votes) / count($votes));
        $this->spotRepository->add($spot, true);
    }
}