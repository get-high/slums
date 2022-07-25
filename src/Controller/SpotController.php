<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return new Response('Hello Word');
    }

    /**
     * @Route("/spot/{slug}")
     */
    public function show($slug)
    {
        return $this->render('spots/show.html.twig', [
             'spot' => $slug
        ]);
    }
}