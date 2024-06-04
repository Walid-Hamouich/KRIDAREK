<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection()
    ]
)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:Announcement:collection", 'read:Announcement'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:Announcement:collection", 'read:Announcement'])]
    private ?string $label = null;

    #[ORM\OneToMany(targetEntity: Property::class, mappedBy: 'city', orphanRemoval: true, cascade: ['remove'])]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setCity($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getCity() === $this) {
                $property->setCity(null);
            }
        }
        return $this;
    }
}
