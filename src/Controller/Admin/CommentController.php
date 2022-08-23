<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CommentController extends AbstractController
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    #[Route("admin/spots/{id<\d+>}/comments", name: "admin_spot_comments", methods: ["GET"])]
    public function edit(Spot $spot)
    {
        $comments = $this->commentRepository->findBy(['spot' => $spot]);

        return $this->render(
            'admin/comments/comments.html.twig', [
            'spot' => $spot,
            'comments' => $comments,
        ]);
    }

    #[Route("admin/comments/{id<\d+>}/destroy", name: "admin_destroy_spot_comment", methods: ["GET", "DELETE"])]
    public function destroy(Comment $comment)
    {
        $this->commentRepository->remove($comment, true);

        $this->addFlash('message', 'Комментарий успешно удален');

        return $this->redirectToRoute('admin_spot_comments', ['id' => $comment->getSpot()->getId()]);
    }
}
