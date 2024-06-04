<?php

namespace App\Controller;

use App\Enum\StatusEnum;
use App\Service\AnnouncementManager;
use App\Service\UserManager;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[IsGranted(('ROLE_ADMIN'))]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index')]
    public function index(
        Environment $twig,
        UserManager $userManager,
        AnnouncementManager $announcementManager
    ): Response {
        $membersCount = $userManager->countMembers();
        $allAnnouncementsCount = $announcementManager->countAllAnnouncements();
        $processingAnnoucementsCount = $announcementManager->countAnnouncementsByStatus(StatusEnum::PROCESSING);
        $html = $twig->render("home/index.html.twig", [
            'members_count' => $membersCount,
            'all_announcements_count' => $allAnnouncementsCount,
            'processing_annoucements_count' => $processingAnnoucementsCount
        ]);
        return new Response($html);
    }
}
