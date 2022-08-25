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

    }

    #[Route(path: '/spots/wish-list', name: 'user_wish_list')]
    public function wishlist()
    {

    }
}