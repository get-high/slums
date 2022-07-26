<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Spot;
use App\Entity\User;
use App\Repository\SpotRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class SpotService
{
    public function __construct(
        private SpotRepository $spotRepository,
        private PaginatorInterface $paginator,
    ) {}

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

    public function paginateLatestPublishedSpotsUserWas(User $user, Request $request,  int $num = 10)
    {
        return $this->paginator->paginate(
            $this->spotRepository->paginateLatestPublishedUserWas($user),
            $request->get('page', 1),
            $num
        );
    }

    public function paginateLatestPublishedSpotsUserWill(User $user, Request $request,  int $num = 10)
    {
        return $this->paginator->paginate(
            $this->spotRepository->paginateLatestPublishedUserWill($user),
            $request->get('page', 1),
            $num
        );
    }

    public function paginateLatestPublishedSpotsByCategory(Category $category, Request $request,  int $num = 10)
    {
        return $this->paginator->paginate(
            $this->spotRepository->paginateLatestPublishedByCategory($category),
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

    public function getMostVisitedSpotsUserWas(User $user, int $num = 6)
    {
        return $this->spotRepository->getMostVisitedUserWas($user, $num);
    }

    public function getMostVisitedSpotsUserWill(User $user, int $num = 6)
    {
        return $this->spotRepository->getMostVisitedUserWill($user, $num);
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