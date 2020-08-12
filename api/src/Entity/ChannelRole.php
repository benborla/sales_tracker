<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelRoleRepository::class)
 */
class ChannelRole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"channel", "channelProfile"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ChannelProfile::class, inversedBy="role")
     */
    private $channelProfile;

    /**
     * @ORM\OneToOne(targetEntity=Role::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"channel", "channelProfile"})
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChannelProfile(): ?ChannelProfile
    {
        return $this->channelProfile;
    }

    public function setChannelProfile(?ChannelProfile $channelProfile): self
    {
        $this->channelProfile = $channelProfile;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
