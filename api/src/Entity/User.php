<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\AbstractEntity;

/**
 * @ApiResource(
 *    normalizationContext={"groups"={"user:read"}},
 *    denormalizationContext={"groups"={"user:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"})
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @Groups({"user:write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=30)
     */
    private $firstName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=30)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReactionTime", mappedBy="user", orphanRemoval=true)
     * @Groups({"user:read"})
     */
    private $reactionTimes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClickTraining", mappedBy="user", orphanRemoval=true)
     * @Groups({"user:read"})
     */
    private $clickTrainings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrackingTraining", mappedBy="user")
     * @Groups({"user:read"})
     */
    private $trackingTrainings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FlickTraining", mappedBy="user", orphanRemoval=true)
     * @Groups({"user:read"})
     */
    private $flickTrainings;

    public function __construct()
    {
        $this->reactionTimes = new ArrayCollection();
        $this->clickTrainings = new ArrayCollection();
        $this->trackingTrainings = new ArrayCollection();
        $this->flickTrainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return "$this->firstName $this->lastName";
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * toArray
     *
     * @access public
     * @return array
     */
    public function toArray()
    {
        $user = \get_object_vars($this);
        unset($user['password']);

        return $user;
    } // End function toArray


    /**
     * @return Collection|ReactionTime[]
     */
    public function getReactionTimes(): Collection
    {
        return $this->reactionTimes;
    }

    public function addReactionTime(ReactionTime $reactionTime): self
    {
        if (!$this->reactionTimes->contains($reactionTime)) {
            $this->reactionTimes[] = $reactionTime;
            $reactionTime->setUser($this);
        }

        return $this;
    }

    public function removeReactionTime(ReactionTime $reactionTime): self
    {
        if ($this->reactionTimes->contains($reactionTime)) {
            $this->reactionTimes->removeElement($reactionTime);
            // set the owning side to null (unless already changed)
            if ($reactionTime->getUser() === $this) {
                $reactionTime->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClickTraining[]
     */
    public function getClickTrainings(): Collection
    {
        return $this->clickTrainings;
    }

    public function addClickTraining(ClickTraining $clickTraining): self
    {
        if (!$this->clickTrainings->contains($clickTraining)) {
            $this->clickTrainings[] = $clickTraining;
            $clickTraining->setUser($this);
        }

        return $this;
    }

    public function removeClickTraining(ClickTraining $clickTraining): self
    {
        if ($this->clickTrainings->contains($clickTraining)) {
            $this->clickTrainings->removeElement($clickTraining);
            // set the owning side to null (unless already changed)
            if ($clickTraining->getUser() === $this) {
                $clickTraining->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrackingTraining[]
     */
    public function getTrackingTrainings(): Collection
    {
        return $this->trackingTrainings;
    }

    public function addTrackingTraining(TrackingTraining $trackingTraining): self
    {
        if (!$this->trackingTrainings->contains($trackingTraining)) {
            $this->trackingTrainings[] = $trackingTraining;
            $trackingTraining->setUser($this);
        }

        return $this;
    }

    public function removeTrackingTraining(TrackingTraining $trackingTraining): self
    {
        if ($this->trackingTrainings->contains($trackingTraining)) {
            $this->trackingTrainings->removeElement($trackingTraining);
            // set the owning side to null (unless already changed)
            if ($trackingTraining->getUser() === $this) {
                $trackingTraining->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FlickTraining[]
     */
    public function getFlickTrainings(): Collection
    {
        return $this->flickTrainings;
    }

    public function addFlickTraining(FlickTraining $flickTraining): self
    {
        if (!$this->flickTrainings->contains($flickTraining)) {
            $this->flickTrainings[] = $flickTraining;
            $flickTraining->setUser($this);
        }

        return $this;
    }

    public function removeFlickTraining(FlickTraining $flickTraining): self
    {
        if ($this->flickTrainings->contains($flickTraining)) {
            $this->flickTrainings->removeElement($flickTraining);
            // set the owning side to null (unless already changed)
            if ($flickTraining->getUser() === $this) {
                $flickTraining->setUser(null);
            }
        }

        return $this;
    }}
