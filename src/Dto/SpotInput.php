<?php

namespace App\Dto;

use App\Validator\ValidCategory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class SpotInput
{
    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?string $title;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Regex(pattern: "/^[a-z_0-9]+$/", message:"Поле slug может состоять только из латинских букв, _ и цифр", groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?string $slug;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?string $address;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?string $description;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?string $content;

    #[Groups(["spot:write"])]
    public ?string $how_to_get;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?float $lat;

    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?float $lng;

    #[NotNull(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?bool $main;

    #[Groups(["spot:write"])]
    public ?string $years;

    #[Groups(["spot:write"])]
    public ?string $authors;

    /**
     * @var int[]
     */
    #[NotNull(groups: ["spot:write", "spot:update"])]
    #[NotBlank(groups: ["spot:write", "spot:update"])]
    #[ValidCategory(groups: ["spot:write", "spot:update"])]
    #[Groups(["spot:write"])]
    public ?array $categories;

    #[NotBlank(groups: ["spot:write"])]
    #[NotNull(groups: ["spot:write"])]
    #[Image(
        mimeTypes: ["image/jpeg"],
        minWidth: 700,
        minHeight: 500,
        groups: ["spot:write", "spot:update"]
    )]
    #[Groups(['spot:write'])]
    public ?UploadedFile $image;

    public static function createFromRequest(Request $request): self
    {
        $dto = new SpotInput();
        $dto->title = $request->get('title');
        $dto->slug = $request->get('slug');
        $dto->address = $request->get('address');
        $dto->description = $request->get('description');
        $dto->content = $request->get('content');
        $dto->how_to_get = $request->get('how_to_get');
        $dto->lat = $request->get('lat');
        $dto->lng = $request->get('lng');
        $dto->main = $request->get('main');
        $dto->years = $request->get('years');
        $dto->authors = $request->get('authors');
        $dto->image = $request->files->get('image');

        foreach ($request->get('categories') as $category) {
            $dto->categories[] = $category;
        }

        return $dto;
    }
}