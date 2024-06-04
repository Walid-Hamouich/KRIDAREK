<?php

namespace App\Service;

use App\Repository\AnnouncementRepository;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementManager
{

    public function __construct(
        private AnnouncementRepository $announcementRepository
    ) {
    }

    public function countByCriteia(Request $request)
    {
        $publishedById = $request->query->get('publishedBy_id');
        $status = $request->query->get('status');
        if ($publishedById) {
            if (!$status) {
                return $this->announcementRepository->countByPublisherId($publishedById);
            } else {
                return $this->announcementRepository->countByPublisherIdAndStatus($publishedById, $status);
            }
        }
        return $this->announcementRepository->count([]);
    }
}
