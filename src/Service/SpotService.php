<?php

namespace App\Service;

use App\Repository\SpotRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class SpotService
{
    private SpotRepository $spotRepository;

    private PaginatorInterface $paginator;

    public function __construct(SpotRepository $spotRepository, PaginatorInterface $paginator)
    {
        $this->spotRepository = $spotRepository;
        $this->paginator = $paginator;
    }

    public function getAllMainSpots()
    {
        return $this->spotRepository->findBy(['main' => true]);
    }

    public function paginateLatesPublishedSpots(Request $request,  int $num = 10)
    {
         return $this->paginator->paginate(
            $this->spotRepository->paginateLatestPublished(),
            $request->get('page', 1),
            $num
        );
    }

    public function getTopRatedSpots(int $num)
    {
        return $this->spotRepository->getTopRated($num);
    }

    public function getMostVisitedSpots(int $num)
    {
        return $this->spotRepository->getMostVisited($num);
    }
}