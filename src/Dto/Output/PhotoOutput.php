<?php

namespace App\Dto\Output;

use App\Entity\Photo;
use Symfony\Component\Serializer\Annotation\Groups;

class PhotoOutput
{
    #[Groups("photo")]
    public int $id;

    #[Groups("photo")]
    public string $description;

    #[Groups("photo")]
    public int $order_by;

    public static function createFromEntity(Photo $photo): self
    {
        $output = new PhotoOutput();
        $output->id = $photo->getId();
        $output->description = $photo->getDescription();
        $output->order_by = $photo->getOrderBy();

        return $output;
    }
}