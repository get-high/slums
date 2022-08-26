<?php

namespace App\Controller;

use App\Service\SpotService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class UserController extends AbstractController
{
    private SpotService $spotService;

    public function __construct(SpotService $spotService)
    {
        $this->spotService = $spotService;
    }

    #[Route(path: '/spots/visited', name: 'user_visited')]
    public function visited(Request $request)
    {
        $latestSpots = $this->spotService->paginateLatestPublishedSpotsUserWas($this->getUser(), $request, 10);
        $more = ($latestSpots->getCurrentPageNumber() * 10 >= $latestSpots->getTotalItemCount()) ? false : true;
        $mostVisitedSpotsUserWas = $this->spotService->getMostVisitedSpotsUserWas($this->getUser(), 6);

        return $this->render('spots/visited.html.twig', [
            'more' => $more,
            'latestSpots' => $latestSpots,
            'mostVisitedSpotsUserWas' => $mostVisitedSpotsUserWas,
        ]);
    }

    #[Route(path: '/spots/wish-list', name: 'user_wish_list')]
    public function wishlist(Request $request)
    {
        $latestSpots = $this->spotService->paginateLatestPublishedSpotsUserWill($this->getUser(), $request, 10);
        $more = ($latestSpots->getCurrentPageNumber() * 10 >= $latestSpots->getTotalItemCount()) ? false : true;
        $mostVisitedSpotsUserWill = $this->spotService->getMostVisitedSpotsUserWill($this->getUser(),6);

        return $this->render('spots/wish-list.html.twig', [
            'more' => $more,
            'latestSpots' => $latestSpots,
            'mostVisitedSpotsUserWill' => $mostVisitedSpotsUserWill,
        ]);
    }
}