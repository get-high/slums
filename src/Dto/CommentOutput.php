<?php

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Comment;
use Symfony\Component\Serializer\Annotation\Groups;

class CommentOutput
{
    #[Groups(["comment"])]
    public int $id;

    #[Groups(["comment"])]
    public string $content;

    #[Groups("comment")]
    public string $user;


    public static function createFromEntity(Comment $comment): self
    {
        $output = new CommentOutput();
        $output->id = $comment->getId();
        $output->content = $comment->getContent();
        $output->user = $comment->getUser()->getName();

        return $output;
    }
}