<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\CommentOutput;
use App\Entity\Comment;

class CommentOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Comment $comment
     */
    public function transform($comment, string $to, array $context = [])
    {
        return CommentOutput::createFromEntity($comment);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CommentOutput::class === $to && $data instanceof Comment;
    }
}