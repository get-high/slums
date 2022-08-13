<?php

namespace App\EventListener;

use App\Entity\Spot;
use App\Entity\Vote;
use App\Repository\SpotRepository;
use App\Repository\VoteRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\ManagerRegistry;


class SpotRatingUpdateListener
{
    private VoteRepository $repository;

    private SpotRepository $spotRepository;

    private ManagerRegistry $doctrine;

    public function __construct(VoteRepository $repository, SpotRepository $spotRepository, ManagerRegistry $doctrine)
    {
        $this->repository = $repository;
        $this->spotRepository = $spotRepository;
        $this->doctrine = $doctrine;
    }

    public function updateSpotRating(Vote $vote, LifecycleEventArgs $event): void
    {
        $votes = array_column($this->repository->findAllVotesOfSpot($vote), 'rating');
        $rating = array_sum($votes) / count($votes);
        $entityManager = $this->doctrine->getManager();
        $spot = $entityManager->getRepository(Spot::class)->find($vote->getSpot());
        $spot->setRating($rating);
        $entityManager->flush();
    }
}