<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Spot;
use App\Service\SpotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $latestSpots = $this->spotService->paginateLatesPublishedSpots($request, 10);
        $topRatedSpots = $this->spotService->getTopRatedSpots(4);
        $mostVisitedSpots = $this->spotService->getMostVisitedSpots(6);

        return $this->render('spots/index.html.twig', [
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
        return $this->render('spots/show.html.twig', [
             'spot' => $spot
        ]);
    }

    /**
     * @Route("/category/{slug}", name="category")
     * @param Category $category
     * @return Response
     */
    public function category(Category $category): Response
    {
        return $this->render('spots/category.html.twig', [
            'category' => $category
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

    /**
     * @Route("/api/was/{id<\d+>}", name="was", methods={"POST"})
     * @param int $id
     * @return JsonResponse
     */
    public function was(int $id): JsonResponse
    {
        $likes = $id;

        return $this->json(['likes' => $likes]);
    }

    /**
     * @Route("/api/will/{id}", name="will", methods={"POST"})
     * @param int $id
     * @return JsonResponse
     */
    public function will(int $id): JsonResponse
    {
        $likes = $id;

        return $this->json(['likes' => $likes]);
    }
}