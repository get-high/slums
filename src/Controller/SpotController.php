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
        return $this->render('spots/index.html.twig', [
            'spot' => 'main'
        ]);
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
     * @Route("/category/{slug}", name="category")
     * @param string $slug
     * @return Response
     */
    public function category(string $slug): Response
    {
        return $this->render('spots/category.html.twig', [
            'category' => $slug
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