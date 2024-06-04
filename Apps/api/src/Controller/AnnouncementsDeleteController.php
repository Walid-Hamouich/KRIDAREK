<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Service\MinIOManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementsDeleteController extends AbstractController
{

    function __construct(private MinIOManager $minIOManager)
    {
    }
    function __invoke(Announcement $announcement, Request $request)
    {
        $user = $this->getUser();
        $images = $announcement->getImages();
        foreach ($images as $image) {
            // $this->minIOManager->deleteFile($image);
        }
        return $announcement;
    }
}
