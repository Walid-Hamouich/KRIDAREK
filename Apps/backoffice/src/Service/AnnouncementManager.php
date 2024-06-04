<?php

namespace App\Service;

use App\Entity\Announcement;
use App\Enum\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;

class AnnouncementManager
{

    public function __construct(private EntityManagerInterface $manager)
    {
    }


    public function findAll(): array
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->findAll();
    }

    public function find(int $id): Announcement
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->find($id);
    }

    public function findBySlug(string $slug): ?Announcement
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->findOneBy(['slug' => $slug]);
    }

    public function findByStatus(string $status)
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->findBy(['status' => $status]);
    }

    public function validate(Announcement $announcement)
    {
        $announcement->setStatus(StatusEnum::PUBLISHED);
        $this->manager->flush();
    }

    public function reject(Announcement $announcement)
    {
        $announcement->setStatus(StatusEnum::NONPUBLISHED);
        $this->manager->flush();
    }

    public function remove(Announcement $announcement)
    {
        $this->manager->remove($announcement);
        $this->manager->flush();
    }

    public function countAllAnnouncements(): int
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->count();
    }

    public function countAnnouncementsByStatus(StatusEnum $status)
    {
        $announcementRepository = $this->manager->getRepository(Announcement::class);
        return $announcementRepository->count(['status' => $status->value]);
    }
}
