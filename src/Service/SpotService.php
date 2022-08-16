<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Spot;
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

    public function getMainSpots()
    {
        return $this->spotRepository->findBy(['main' => true]);
    }

    public function getCategoryMainSpots(Category $category)
    {
        return $this->spotRepository->getCategoryMainSpots($category);
    }

    public function paginateLatestPublishedSpots(Request $request,  int $num = 10)
    {
         return $this->paginator->paginate(
            $this->spotRepository->paginateLatestPublished(),
            $request->get('page', 1),
            $num
        );
    }

    public function paginateCategoryLatestPublishedSpots(Category $category, Request $request,  int $num = 10)
    {
        return $this->paginator->paginate(
            $this->spotRepository->paginateCategoryLatestPublished($category),
            $request->get('page', 1),
            $num
        );
    }

    public function getTopRatedSpots(int $num = 4)
    {
        return $this->spotRepository->getTopRated($num);
    }

    public function getRandomSpots(int $num = 6)
    {
        return $this->spotRepository->getRandom($num);
    }

    public function getCategoryTopRatedSpots(Category $category, int $num = 4)
    {
        return $this->spotRepository->getCategoryTopRated($category, $num);
    }

    public function getMostVisitedSpots(int $num = 6)
    {
        return $this->spotRepository->getMostVisited($num);
    }

    public function getCategoryMostVisitedSpots(Category $category, int $num = 6)
    {
        return $this->spotRepository->getCategoryMostVisited($category, $num);
    }

    public function find(int $id)
    {
        return $this->spotRepository->find($id);
    }

    public function update(Spot $spot)
    {
        $this->spotRepository->add($spot, true);
    }
}