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
     * @ORM\Column(type="string", length=155)
     * @Groups({"channel", "channelProfile"})
     */
    private $roleKey;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"channel", "channelProfile"})
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
