<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\AnnouncementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: AnnouncementRepository::class)]
#[HasLifecycleCallbacks]
class Announcement
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;

    #[ORM\Column]
    private ?bool $sponsored = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sponsorDate = null;

    #[ORM\Column]
    private ?int $sponsorDuration = null;

    #[ORM\Column]
    private ?bool $available = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPhone = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $images = [];

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'announcement', cascade: ['remove'])]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoriteAnnouncements', cascade: ['remove'])]
    private Collection $bookmarkers;

    #[ORM\ManyToOne(inversedBy: 'publishedAnnouncements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $publishedBy = null;

    #[ORM\ManyToOne(inversedBy: 'validatedAnnouncements')]
    private ?User $validatedBy = null;

    #[ORM\ManyToOne(inversedBy: 'announcements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    // #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?float $area = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->bookmarkers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status->value;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isSponsored(): ?bool
    {
        return $this->sponsored;
    }

    public function setSponsored(bool $sponsored): static
    {
        $this->sponsored = $sponsored;

        return $this;
    }

    public function getSponsorDate(): ?\DateTimeInterface
    {
        return $this->sponsorDate;
    }

    public function setSponsorDate(\DateTimeInterface $sponsorDate): static
    {
        $this->sponsorDate = $sponsorDate;

        return $this;
    }

    public function getSponsorDuration(): ?int
    {
        return $this->sponsorDuration;
    }

    public function setSponsorDuration(int $sponsorDuration): static
    {
        $this->sponsorDuration = $sponsorDuration;

        return $this;
    }

    public function IsAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): static
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setAnnouncement($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getAnnouncement() === $this) {
                $review->setAnnouncement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getBookmarkers(): Collection
    {
        return $this->bookmarkers;
    }

    public function addBookmarker(User $user): static
    {
        if (!$this->bookmarkers->contains($user)) {
            $this->bookmarkers->add($user);
            $user->addFavoriteAnnouncement($this);
        }

        return $this;
    }

    public function removeBookmarker(User $user): static
    {
        if ($this->bookmarkers->removeElement($user)) {
            $user->removeFavoriteAnnouncement($this);
        }

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getPublishedBy(): ?User
    {
        return $this->publishedBy;
    }

    public function setPublishedBy(?User $publishedBy): static
    {
        $this->publishedBy = $publishedBy;

        return $this;
    }

    public function getValidatedBy(): ?User
    {
        return $this->validatedBy;
    }

    public function setValidatedBy(?User $validatedBy): static
    {
        $this->validatedBy = $validatedBy;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[PrePersist]
    public function setCreationDate(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    #[PreUpdate]
    public function setUpdateDate(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(float $area): static
    {
        $this->area = $area;

        return $this;
    }
}
