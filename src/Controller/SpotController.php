<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotController
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
    public function spot($slug)
    {
        return new Response(sprintf('Spot: %s', $slug));
    }
}