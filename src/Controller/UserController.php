<?php

namespace App\Controller;

use App\Service\SpotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private SpotService $spotService;

    public function __construct(SpotService $spotService)
    {
        $this->spotService = $spotService;
    }

    /**
     * @Route("/spots/visited", name="visited")
     * @return Response
     */
    public function visited(): Response
    {

    }

    /**
     * @Route("/spot/wish-list", name="wish_list")
     * @return Response
     */
    public function wishlist(): Response
    {

    }
}