<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return new Response('Hello Word');
    }

    /**
     * @Route("/spot/{slug}", name="show_spot")
     */
    public function show($slug)
    {
        return $this->render('spots/show.html.twig', [
             'spot' => $slug
        ]);
    }
}