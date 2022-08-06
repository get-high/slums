<?php

namespace App\Controller\Admin;

use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SpotController extends AbstractController
{
    #[Route('admin/spot/controller', name: 'app_admin_spot_controller')]
    public function index(SpotRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $spots = $repository->find(1);

        $spots = $serializer->serialize($spots, 'json');

        return $this->json([
            'message' => 'Spots',
            'spots' => $spots,
        ]);
    }
}
