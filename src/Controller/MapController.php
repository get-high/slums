<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\SpotRepository;
use App\Service\SpotService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    private SpotService $spotService;

    private SpotRepository $spotRepository;

    public function __construct(SpotService $spotService, SpotRepository $spotRepository)
    {
        $this->spotService = $spotService;
        $this->spotRepository = $spotRepository;
    }

    /**
     * @Route("/api/map", name="map_index", methods={"GET", "POST"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $spots = $this->spotRepository->getPublished();

        return $this->json([
            'type' => 'FeatureCollection',
            'features' => $this->getMapObjects($spots),
        ]);
    }

    /**
     * @Route("/api/map/category/{id}", name="map_category", methods={"POST"})
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function category(Category $category, Request $request): Response
    {
        // JSON с точками раздела
    }

    /**
     * @Route("/api/map/visited", name="map_visited_spots", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Request $request
     * @return Response
     */
    public function visited(Request $request): Response
    {
        // JSON для карты с точками в которых был пользователь
    }

    /**
     * @Route("/api/map/wish-list", name="map_wish_list", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Request $request
     * @return Response
     */
    public function wishlist(Request $request): Response
    {
        // JSON для карты с точками в которых пользователь хочет побывать
    }

    private function getMapObjects(array $spots)
    {
        $json = [];

        foreach ($spots as $spot) {
            $balloonContent = $this->renderView('parts/balloon.html.twig', [
                'spot' => $spot,
            ]);

            $json[] = [
                'type' => 'Feature',
                'id' => $spot->getId(),
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $spot->getLat(),
                        $spot->getLng(),
                    ],
                ],
                'properties' => [
                    'balloonContent' => $balloonContent,
                ],
                'options' => [
                    'iconLayout' => 'default#image',
                    'iconImageHref' => 'images/newspot.png',
                    'iconImageSize' => [48, 48],
                    'iconImageOffset' => [-24, -24],
                ]
            ];
        }

        return $json;
    }
}