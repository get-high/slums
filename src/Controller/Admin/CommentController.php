<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Repository\CommentRepository;
use App\Repository\SpotRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CommentController extends AbstractController
{
    private SpotRepository $spotRepository;

    private CommentRepository $commentRepository;

    public function __construct(SpotRepository $spotRepository, CommentRepository $commentRepository)
    {
        $this->spotRepository = $spotRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route("admin/spots/{id<\d+>}/comments", name: "admin_spot_comments", methods: ["GET"])]
    public function edit(Spot $spot, Request $request)
    {

    }

    #[Route("admin/comments/{id<\d+>}/destroy", name: "admin_destroy_spot_comment", methods: ["GET", "DELETE"])]
    public function destroy(Comment $comment)
    {

    }
}
