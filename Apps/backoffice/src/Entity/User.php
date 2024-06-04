<?php

namespace App\Entity;

use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity('email', message: 'Il existe déjà un utilisateur avec cet email.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\Regex('/^[^0-9%_,;:@]+$/', message: 'Ce champs ne doit pas contenir des nombres et les carcatères spéciaux (%_,;:@)')]
    #[Assert\Length(min: 3, max: 15, minMessage: 'Ce champs est trés court: {{ limit }}', maxMessage: 'Ce champs est trés long: {{ limit }}')]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    #[Assert\Regex('/^[^0-9%_,;:@]+$/', message: 'Ce champs ne doit pas contenir des nombres et les carcatères spéciaux (%_,;:@)')]
    #[Assert\Length(min: 3, max: 15, minMessage: 'Ce champs est trés court: {{ limit }}', maxMessage: 'Ce champs est trés long: {{ limit }}')]
    private ?string $firstName = null;

    #[ORM\Column(length: 30)]
    #[Assert\Regex('/^0[67]\d{8}/', message: 'Ce champs n\'pas valide')]
    private ?string $phoneNum = null;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $blackListed = false;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'user', orphanRemoval: true, cascade: ['remove'])]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Announcement::class, inversedBy: 'users', cascade: ['remove'])]
    private Collection $favoriteAnnouncements;

    #[ORM\OneToMany(
        targetEntity: Announcement::class,
        mappedBy: 'publishedBy',
        orphanRemoval: true,
        cascade: ['remove']
    )]
    private Collection $publishedAnnouncements;

    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: 'validatedBy')]
    private Collection $validatedAnnouncements;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->favoriteAnnouncements = new ArrayCollection();
        $this->publishedAnnouncements = new ArrayCollection();
        $this->validatedAnnouncements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phoneNum;
    }

    public function setPhoneNum(string $phoneNum): static
    {
        $this->phoneNum = $phoneNum;

        return $this;
    }

    public function isBlackListed(): ?bool
    {
        return $this->blackListed;
    }

    public function setBlackListed(bool $blackListed): static
    {
        $this->blackListed = $blackListed;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getFavoriteAnnouncements(): Collection
    {
        return $this->favoriteAnnouncements;
    }

    public function removeFavoriteAnnouncement(Announcement $favoriteAnnouncement): static
    {
        $this->favoriteAnnouncements->removeElement($favoriteAnnouncement);

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getPublishedAnnouncements(): Collection
    {
        return $this->publishedAnnouncements;
    }

    public function addPublishedAnnouncement(Announcement $publishedAnnouncement): static
    {
        if (!$this->publishedAnnouncements->contains($publishedAnnouncement)) {
            $this->publishedAnnouncements->add($publishedAnnouncement);
            $publishedAnnouncement->setPublishedBy($this);
        }

        return $this;
    }

    public function removePublishedAnnouncement(Announcement $publishedAnnouncement): static
    {
        if ($this->publishedAnnouncements->removeElement($publishedAnnouncement)) {
            // set the owning side to null (unless already changed)
            if ($publishedAnnouncement->getPublishedBy() === $this) {
                $publishedAnnouncement->setPublishedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getValidatedAnnouncements(): Collection
    {
        return $this->validatedAnnouncements;
    }

    public function removeValidatedAnnouncement(Announcement $validatedAnnouncement): static
    {
        if ($this->validatedAnnouncements->removeElement($validatedAnnouncement)) {
            // set the owning side to null (unless already changed)
            if ($validatedAnnouncement->getValidatedBy() === $this) {
                $validatedAnnouncement->setValidatedBy(null);
            }
        }

        return $this;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    public function addFavoriteAnnouncement(Announcement $favoriteAnnouncement): static
    {
        if (!$this->favoriteAnnouncements->contains($favoriteAnnouncement)) {
            $this->favoriteAnnouncements->add($favoriteAnnouncement);
        }

        return $this;
    }

    public function addValidatedAnnouncement(Announcement $validatedAnnouncement): static
    {
        if (!$this->validatedAnnouncements->contains($validatedAnnouncement)) {
            $this->validatedAnnouncements->add($validatedAnnouncement);
            $validatedAnnouncement->setValidatedBy($this);
        }

        return $this;
    }
}
