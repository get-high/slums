<?php

namespace App\Service;

use App\Entity\Photo;
use App\Entity\Spot;
use App\Entity\User;
use League\Flysystem\Filesystem;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Symfony\Component\HttpFoundation\File\File;

class ImageUploader
{
    private Filesystem $filesystem;

    private FilterManager $filterManager;

    private DataManager $dataManager;

    private array $filters;

    public function __construct(Filesystem $filesystem, FilterManager $filterManager, DataManager $dataManager, array $filters)
    {
        $this->filesystem = $filesystem;
        $this->filterManager = $filterManager;
        $this->dataManager = $dataManager;
        $this->filters = $filters;
    }

    /**
     * @param File $file
     * @param Spot|User|Photo $entity
     */
    public function uploadImage(File $file, Spot|User|Photo $entity)
    {
        $this->filesystem->write($entity->getId().'.jpg', file_get_contents($file->getPathname()));

        foreach ($this->filters as $key => $filter) {
            $binary = $this->dataManager->find($filter.'_'.$key, $entity->getId().'.jpg');

            $preview = $this->filterManager->applyFilter($binary, $filter.'_'.$key);

            $this->filesystem->write($entity->getId().'-'.$key.'.jpg', $preview->getContent());
        }
    }

}