<?php

namespace App\Controller\Admin;

use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SpotController extends AbstractController
{
    #[Route('admin/spot/controller', name: 'app_admin_spot_controller')]
    public function index(SpotRepository $repository): JsonResponse
    {
        $spots = $repository->find(1);

        return $this->json([
            'message' => 'Spots',
            'spots' => $spots,
        ], 200, [], ['groups' => ['main']]);
    }
}
