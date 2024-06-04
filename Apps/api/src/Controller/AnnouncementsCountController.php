<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use App\Service\AnnouncementManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementsCountController extends AbstractController
{
    public function __construct(
        private AnnouncementManager $announcementManager
    ) {
    }
    public function __invoke(Request $request, AnnouncementRepository $announcementRepository)
    {
        $count = $this->announcementManager->countByCriteia($request);
        return $this->json([
            "count" => $count
        ]);
        // $repository = $this->manager->getRepository(Announcement::class);
        // $count = $repository->count();
        // dd($count);
        // return [
        //     'count' => $count,
        // ];
    }
}
