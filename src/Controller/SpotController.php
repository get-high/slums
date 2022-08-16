<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Spot;
use App\Service\SpotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotController extends AbstractController
{
    private SpotService $spotService;

    public function __construct(SpotService $spotService)
    {
        $this->spotService = $spotService;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $latestSpots = $this->spotService->paginateLatestPublishedSpots($request, 10);
        $topRatedSpots = $this->spotService->getTopRatedSpots(4);
        $mostVisitedSpots = $this->spotService->getMostVisitedSpots(6);
        $more = ($latestSpots->getCurrentPageNumber() * 10 >= $latestSpots->getTotalItemCount()) ? false : true;

        return $this->render('spots/spots.html.twig', [
            'more' => $more,
            'latestSpots' => $latestSpots,
            'topRatedSpots' => $topRatedSpots,
            'mostVisitedSpots' => $mostVisitedSpots,
        ]);
    }

    /**
     * @Route("/spot/{slug}", name="show_spot")
     * @param Spot $spot
     * @return Response
     */
    public function show(Spot $spot): Response
    {
        $randomSpots = $this->spotService->getRandomSpots(6);

        return $this->render('spots/show.html.twig', [
            'randomSpots' => $randomSpots,
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/category/{slug}", name="category")
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function category(Category $category, Request $request): Response
    {
        $latestSpots = $this->spotService->paginateCategoryLatestPublishedSpots($category, $request, 10);
        $topRatedSpots = $this->spotService->getCategoryTopRatedSpots($category, 4);
        $mostVisitedSpots = $this->spotService->getCategoryMostVisitedSpots($category, 6);
        $more = $latestSpots->getCurrentPageNumber() * 10 >= $latestSpots->getTotalItemCount() ? false : true;

        return $this->render('spots/spots.html.twig', [
            'more' => $more,
            'category' => $category,
            'latestSpots' => $latestSpots,
            'topRatedSpots' => $topRatedSpots,
            'mostVisitedSpots' => $mostVisitedSpots,
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @return Response
     */
    public function search(): Response
    {
        return new Response('Hello Word');
    }
}