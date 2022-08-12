<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Spot;
use App\Repository\PhotoRepository;
use App\Service\ImageUploader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class PhotoFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private ImageUploader $photoUploader;

    private PhotoRepository $repository;

    private static $photoImages = [
        '25.jpg',
        '26.jpg',
        '27.jpg',
        '28.jpg',
        '29.jpg',
        '30.jpg',
        '31.jpg',
        '32.jpg',
        '33.jpg',
        '34.jpg',
    ];

    public function __construct(PhotoRepository $repository, ImageUploader $photoUploader)
    {
        $this->repository = $repository;
        $this->photoUploader = $photoUploader;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Photo::class, 50, function (Photo $photo) {
            $photo
                ->setDescription($this->faker->text(200))
                ->setOrderBy($this->faker->numberBetween(0,10))
                ->setSpot($this->getRandomReference(Spot::class))
            ;
        });

        $manager->flush();

        $photos = $this->repository->findAll();

        foreach ($photos as $photo) {
            $fileName = $this->faker->randomElement(self::$photoImages);

            $tmpFileName = sys_get_temp_dir().'/'.$fileName;

            (new Filesystem())->copy(dirname(dirname(__DIR__)).'/public/images/objects/photos/'.$fileName, $tmpFileName, true);

            $this->photoUploader->uploadImage(new File($tmpFileName), $photo);
        }
    }

    public function getDependencies()
    {
        return [
            SpotFixtures::class,
        ];
    }
}
