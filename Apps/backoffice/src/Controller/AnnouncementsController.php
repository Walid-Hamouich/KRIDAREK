<?php

namespace App\Controller;

use App\Enum\StatusEnum;
use App\Service\AnnouncementManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(('ROLE_ADMIN'))]
#[Route('/announcements')]
class AnnouncementsController extends AbstractController
{
    public function __construct(private AnnouncementManager $announcementManager)
    {
    }

    #[Route('', name: 'app_announcements_index')]
    public function index(Request $request): Response
    {
        $status = $request->query->get('status');
        $statuses = array_column(StatusEnum::cases(), 'value');
        if (in_array($status, $statuses, true)) {
            $announcements = $this->announcementManager->findByStatus($status);
        } else {
            $announcements = $this->announcementManager->findAll();
        }
        return $this->render('announcements/index.html.twig', [
            'announcements' => $announcements,
            'statuses' => $statuses,
            'activeStatus' => $status
        ]);
    }

    #[Route('/{slug}', name: 'app_announcements_show', methods: ['GET'])]
    public function show(string $slug): Response
    {
        $announcement = $this->announcementManager->findBySlug($slug);
        if ($announcement == null) {
            return $this->redirectToRoute('app_announcements_index');
        }
        return $this->render('announcements/show.html.twig', [
            'announcement' => $announcement
        ]);
    }

    #[Route(
        '/{id}',
        requirements: ['id' => '\d+'],
        name: 'app_announcements_remove',
        methods: ['DELETE']
    )]
    public function remove(int $id): Response
    {
        $announcement = $this->announcementManager->find($id);
        if ($announcement != null) {
            $this->announcementManager->remove($announcement);
            $this->addFlash('success', 'Vous avez supprimé l\'annonce avec succés');
        }
        return $this->redirect('app_announcements_index');
    }

    #[Route('/{id}/validate', name: 'app_announcements_validate', methods: ['PATCH'])]
    public function validate(Request $request, int $id)
    {
        $announcement = $this->announcementManager->find($id);
        if ($announcement !== null && $announcement->getStatus() === StatusEnum::PROCESSING->value) {
            $this->announcementManager->validate($announcement);
            $this->addFlash('success', 'Vous avez validé l\'annonce avec succés');
            $prevRoute = $request->headers->get('referer');
            return $this->redirect($prevRoute);
        }
        return $this->redirectToRoute('app_announcements_index');
    }

    #[Route(
        '/{id}/reject',
        name: 'app_announcements_reject',
        methods: ['PATCH']
    )]
    public function reject(Request $request, int $id)
    {
        $announcement = $this->announcementManager->find($id);
        if ($announcement !== null && $announcement->getStatus() === StatusEnum::PROCESSING->value) {
            $this->announcementManager->reject($announcement);
            $this->addFlash('success', 'Vous avez rejeter l\'annonce avec succés');
            $prevRoute = $request->headers->get('referer');
            return $this->redirect($prevRoute);
        }
        return $this->redirectToRoute('app_announcements_index');
    }
}
