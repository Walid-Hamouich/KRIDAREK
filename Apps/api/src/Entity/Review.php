<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Put(
            security: 'is_granted("ROLE_USER") and user.getId() === object.getUser().getId()',
            openapi: new Operation(
                summary: 'Update a review',
                security: [
                    ['bearerAuth' => []]
                ]
            ),
        ),
        new Post(
            security: 'is_granted("ROLE_USER")',
            openapi: new Operation(
                summary: 'Add a new review',
                security: [
                    ['bearerAuth' => []]
                ]
            )
        ),
        new Delete(
            security: 'is_granted("ROLE_USER") and user.getId() === object.getUser().getId()',
            openapi: new Operation(
                summary: 'Delete a review',
                security: [
                    ['bearerAuth' => []]
                ]
            )
        ),
    ]
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $evaluation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateReview = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Announcement $announcement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEvaluation(): ?int
    {
        return $this->evaluation;
    }

    public function setEvaluation(int $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getDateReview(): ?\DateTimeInterface
    {
        return $this->dateReview;
    }

    public function setDateReview(\DateTimeInterface $dateReview): static
    {
        $this->dateReview = $dateReview;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement(?Announcement $announcement): static
    {
        $this->announcement = $announcement;

        return $this;
    }
}
