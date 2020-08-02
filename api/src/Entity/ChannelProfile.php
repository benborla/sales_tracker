<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    normalizationContext={"groups"={"channelProfile:read", "channelProfile"}},
 * )
 * @ORM\Entity(repositoryClass=ChannelProfileRepository::class)
 */
class ChannelProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"channel",  "user"})
     */
    private $id;

    /**
     * @Groups({"channel", "channelProfile", "user:read"})
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Groups({"channel", "channelProfile", "user:read"})
     * @ORM\OneToMany(targetEntity=ChannelRole::class, mappedBy="channelProfile")
     */
    private $roles;

    /**
     * @Groups({"user:read"})
     * @ORM\ManyToOne(targetEntity=Channel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $channel;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     * @return Collection|ChannelRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(ChannelRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->setChannelProfile($this);
        }

        return $this;
    }

    public function removeRole(ChannelRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            // set the owning side to null (unless already changed)
            if ($role->getChannelProfile() === $this) {
                $role->setChannelProfile(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }
}
