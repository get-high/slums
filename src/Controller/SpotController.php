<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return new Response('Hello Word');
    }

    /**
     * @Route("/spot/{slug}", name="show_spot")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        return $this->render('spots/show.html.twig', [
             'spot' => $slug
        ]);
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