<?php

namespace App\Controller;

use ApiPlatform\Symfony\Validator\Exception\ValidationException;
use App\Entity\Announcement;
use App\Entity\Property;
use App\Entity\User;
use App\Enum\StatusEnum;
use App\Service\AnnouncementMapper;
use App\Service\FileHasher;
use App\Service\MinIOManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnnouncementsPostController extends AbstractController
{

    public function __construct(
        private ValidatorInterface $validator,
        private AnnouncementMapper $announcementMapper,
        private MinIOManager $minIOManager,
        private FileHasher $fileHasher
    ) {
    }
    function __invoke(Request $request)
    {
        $announcement = $this->announcementMapper->fromRequest($request);
        $errors = $this->validator->validate($announcement);
        if (count($errors) > 0) {
            return new ValidationException($errors);
        }
        /**
         * @var UploadedFile[]
         */
        $images = $request->files->get('images') ?? [];
        $imagesFileNames = [];
        foreach ($images as $image) {
            $imagesFileNames[] = $this->fileHasher->hashFile($image);
        }
        $announcement->setImages($imagesFileNames);
        for ($i = 0; $i < count($images ?? []); $i++) {
            $this->minIOManager->uploadFile(
                key: $imagesFileNames[$i],
                filePath: $images[$i]->getPathname()
            );
        }

        return $announcement;
    }
}
