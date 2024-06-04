<?php

namespace App\Service;

use App\Entity\Announcement;
use App\Entity\Property;
use App\Entity\User;
use App\Enum\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementMapper
{

    public function __construct(
        private EntityManagerInterface $manager,
        private FileHasher $fileHasher
    ) {
    }

    public function fromRequest(Request $request, int $id = null): Announcement
    {
        $title = $request->request->get('title');
        $price = $request->request->get('price');
        $description = $request->request->get('description');
        $publishedById = $request->request->get('publishedById');
        $contactPhone = $request->request->get('contactPhone');
        $area = $request->request->get('area');
        $propertyId = $request->request->get('propertyId');
        /**
         * @var UploadedFile[]
         */
        $images = $request->files->get('images') ?: [];
        $imagesFileNames = [];
        foreach ($images as $image) {
            $imagesFileNames[] = $this->fileHasher->hashFile($image);
        }
        /**
         * @var Announcement
         */
        $announcement = null;
        if ($id) {
            $announcement = $this->manager->find(Announcement::class, $id);
            if ($announcement == null) return null;
        } else {
            $announcement = new Announcement();
            $announcement->setImages($imagesFileNames);
        }

        $user = $this->manager->find(User::class, $publishedById);
        $property = $this->manager->find(Property::class, $propertyId);

        $announcement
            ->setTitle($title)
            ->setPrice($price)
            ->setDescription($description)
            ->setStatus(StatusEnum::PROCESSING)
            ->setSponsored(false)
            ->setAvailable(true)
            ->setSponsorDate(new \DateTime())
            ->setSponsorDuration(0)
            ->setContactPhone($contactPhone)
            ->setArea($area)
            ->setPublishedBy($user)
            ->setProperty($property);

        return $announcement;
    }
}
