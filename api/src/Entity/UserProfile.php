<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserProfileRepository::class)
 */
class UserProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @Groups({"user"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userProfiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups({"user"})
     * @ORM\OneToOne(targetEntity=ChannelProfile::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getProfile(): ?ChannelProfile
    {
        return $this->profile;
    }

    public function setProfile(ChannelProfile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }
}
