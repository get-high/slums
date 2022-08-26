<?php

namespace App\Controller;

use App\Service\SpotService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function visited()
    {
        $latestSpots = $this->getUser()->getSpotsUserWas();
        $mostVisitedSpotsUserWas = $this->spotService->getMostVisitedSpotsUserWas($this->getUser(), 6);

        return $this->render('spots/visited.html.twig', [
            'more' => false,
            'latestSpots' => $latestSpots,
            'mostVisitedSpotsUserWas' => $mostVisitedSpotsUserWas,
        ]);
    }

    #[Route(path: '/spots/wish-list', name: 'user_wish_list')]
    public function wishlist()
    {
        $latestSpots = $this->getUser()->getSpotsUserWill();
        $mostVisitedSpotsUserWill = $this->spotService->getMostVisitedSpotsUserWill($this->getUser(),6);

        return $this->render('spots/wish-list.html.twig', [
            'more' => false,
            'latestSpots' => $latestSpots,
            'mostVisitedSpotsUserWill' => $mostVisitedSpotsUserWill,
        ]);
    }
}