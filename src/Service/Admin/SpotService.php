<?php

namespace App\Service\Admin;

use App\Entity\Spot;
use App\Exception\SpotAlreadyExistsException;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class SpotService
{
    public function __construct(
        private EntityManagerInterface $em,
        private SpotRepository $spotRepository,
        private SluggerInterface $slugger,
        private Security $security,
        private ImageUploader $spotUploader)
    {
    }

    public function publish(int $id, PublishSpotRequest $publishSpotRequest): void
    {
        $this->setPublicationDate($id, $publishSpotRequest->getDate());
    }

    public function unpublish(int $id): void
    {
        $this->setPublicationDate($id, null);
    }

    public function getBooks(): SpotListResponse
    {
        return new SpotListResponse(
            array_map([$this, 'map'],
                $this->spotRepository->getAllSpots())
        );
    }

    public function createSpot(CreateSpotRequest $request): IdResponse
    {
        $slug = $this->slugger->slug($request->getTitle());
        if ($this->spotRepository->existsBySlug($slug)) {
            throw new SpotAlreadyExistsException();
        }

        $spot = (new Spot())
            ->setTitle($request->getTitle())
            ->setSlug($slug)
            ->setCreator($this->security->getUser());

        $this->em->persist($spot);
        $this->em->flush();

        //$this->uploadCover($spot, );

        return new IdResponse($spot->getId());
    }

    public function deleteSpot(int $id): void
    {
        $spot = $this->spotRepository->getSpotById($id);

        $this->em->remove($spot);
        $this->em->flush();
    }

    private function setPublicationDate(int $id, ?DateTimeInterface $dateTime): void
    {
        $spot = $this->spotRepository->getSpotById($id);
        $spot->setPublicationDate($dateTime);

        $this->em->flush();
    }

    private function map(Spot $spot): SpotListItem
    {
        return (new SpotListItem())
            ->setId($spot->getId())
            ->setSlug($spot->getSlug())
            ->setTitle($spot->getTitle());
    }

    private function uploadCover(Spot $spot, UploadedFile $file)//: UploadCoverResponse
    {
        //$spot = $this->spotRepository->getSpotById($id);
        $this->spotUploader->uploadImage($file, $spot);
    }
}