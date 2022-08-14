<?php

namespace App\EventListener;

use App\Entity\Vote;
use App\Repository\SpotRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SpotRatingUpdateListener
{
    private VoteRepository $voteRepository;

    private SpotRepository $spotRepository;

    private EntityManagerInterface $em;

    public function __construct(VoteRepository $voteRepository, SpotRepository $spotRepository, EntityManagerInterface $em)
    {
        $this->voteRepository = $voteRepository;
        $this->spotRepository = $spotRepository;
        $this->em = $em;
    }

    public function updateSpotRating(Vote $vote, LifecycleEventArgs $event): void
    {
        $votes = array_column($this->voteRepository->arrayAllVotesOfSpot($vote), 'rating');
        $spot = $this->spotRepository->find($vote->getSpot());
        $spot->setRating(array_sum($votes) / count($votes));
        $this->spotRepository->add($spot, true);
    }
}