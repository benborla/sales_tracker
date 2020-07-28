<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChannelProfileRepository::class)
 */
class ChannelProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Channel::class, cascade={"persist", "remove"})
     */
    private $channel;

    /**
     * @ORM\OneToMany(targetEntity=ChannelRole::class, mappedBy="channelProfile")
     */
    private $role;

    public function __construct()
    {
        $this->role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return Collection|ChannelRole[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(ChannelRole $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
            $role->setChannelProfile($this);
        }

        return $this;
    }

    public function removeRole(ChannelRole $role): self
    {
        if ($this->role->contains($role)) {
            $this->role->removeElement($role);
            // set the owning side to null (unless already changed)
            if ($role->getChannelProfile() === $this) {
                $role->setChannelProfile(null);
            }
        }

        return $this;
    }
}
