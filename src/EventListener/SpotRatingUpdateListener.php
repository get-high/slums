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
        $votes = array_column($this->voteRepository->findAllVotesOfSpot($vote), 'rating');
        $rating = array_sum($votes) / count($votes);
        $spot = $this->spotRepository->find($vote->getSpot());
        $spot->setRating($rating);
        $this->em->flush();
    }
}