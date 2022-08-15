<?php

namespace App\Controller;

use App\Entity\Category;
use App\Service\SpotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    private SpotService $spotService;

    public function __construct(SpotService $spotService)
    {
        $this->spotService = $spotService;
    }

    /**
     * @Route("/api", name="ajax_index", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $latestSpots = $this->spotService->paginateLatestPublishedSpots($request);

        return $this->latestSpots($latestSpots);
    }

    /**
     * @Route("/api/category/{id}", name="ajax_category", methods={"POST"})
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function category(Category $category, Request $request): Response
    {
        $latestSpots = $this->spotService->paginateCategoryLatestPublishedSpots($category, $request);

        return $this->latestSpots($latestSpots);
    }

    private function latestSpots($latestSpots)
    {
        $spots = $this->render('parts/spot-bit.html.twig', [
            'latestSpots' => $latestSpots,
        ]);

        $more = $latestSpots->getCurrentPageNumber() * 10 >= $latestSpots->getTotalItemCount() ? false : true;

        return $this->json([
            'spots' => $spots->getContent(),
            'more' => $more,
        ]);
    }
}