<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Controller\PropertyPostController;
use App\Enum\ActionEnum;
use App\Enum\TypeEnum;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            controller: PropertyPostController::class,
            openapi: new Operation(
                summary: 'Add a new announcement',
                security: [
                    ['bearerAuth' => []]
                ]
            ),
            security: 'is_granted("ROLE_USER")'
        )
    ]
)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:Announcement:collection"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: TypeEnum::class)]
    #[Groups(["read:Announcement:collection", 'read:Announcement'])]
    private ?TypeEnum $type = null;

    #[ORM\Column(length: 255, enumType: ActionEnum::class)]
    #[Groups(["read:Announcement:collection", 'read:Announcement'])]
    private ?ActionEnum $action = null;

    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: 'property', orphanRemoval: true)]
    private Collection $announcements;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:Announcement:collection", 'read:Announcement'])]
    private ?City $city = null;

    public function __construct()
    {
        $this->announcements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type->value;
    }

    public function setType(TypeEnum $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action->value;
    }

    public function setAction(ActionEnum $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): static
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
            $announcement->setProperty($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): static
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getProperty() === $this) {
                $announcement->setProperty(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }
}
