<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    collectionOperations={
 *        "post" = { "security_post_denormalize" = "is_granted('CREATE', object)" },
 *        "get"
 *    },
 *   itemOperations={
 *        "get" = { "security" = "is_granted('READ', object)" },
 *        "put" = { "security" = "is_granted('UPDATE', object)" },
 *        "patch" = { "security" = "is_granted('UPDATE', object)" },
 *        "delete" = { "security" = "is_granted('DELETE', object)" }
 *     },
 * )
 * @ORM\Entity(repositoryClass=ChannelRoleRepository::class)
 */
class ChannelRole
{
    public const REL_PROPERTY_KEY = '';

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
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(nullable=false)
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

    /**
     * @Groups({"user:collection:get", "user:item:get", "channelProfile:read"})
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
