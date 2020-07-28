<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRoleRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155)
     */
    private $roleKey;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $roleName;

    /**
     * @ORM\ManyToOne(targetEntity=ChannelProfile::class, inversedBy="role")
     */
    private $channelProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleKey(): ?string
    {
        return $this->roleKey;
    }

    public function setRoleKey(string $roleKey): self
    {
        $this->roleKey = $roleKey;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): self
    {
        $this->roleName = $roleName;

        return $this;
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
}
