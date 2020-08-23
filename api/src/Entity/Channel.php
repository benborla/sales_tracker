<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\NewChannelAction;
use App\Controller\NewProfileAction;
use App\Entity\Traits\TimestampableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    collectionOperations={
 *        "post"={
 *            "controller"=NewChannelAction::class
 *        },
 *        "get"
 *    },
 *    itemOperations={
 *      "get",
 *      "put",
 *      "patch",
 *      "delete",
 *      "post_new_profile"={
 *          "controller"=NewProfileAction::class,
 *          "method"="POST",
 *          "path"="/channel/{id}/profile"
 *      }
 *    },
 *    normalizationContext={"groups"={"channel:read", "channel"}},
 *    denormalizationContext={"groups"={"user:write"}},
 * )
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Channel implements BlameableInterface
{
    use TimestampableTrait;
    use BlameableTrait;

    public const REL_PROPERTY_KEY = '';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Groups({"channel"})
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"channel"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"channel"})
     */
    private $isArchived;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"channel"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"channel"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=ChannelProfile::class, mappedBy="channel")
     * @Groups({"channel"})
     */
    private $channelProfiles;

    public function __construct()
    {
        $this->channelProfiles = new ArrayCollection();
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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(?bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|ChannelProfile[]
     */
    public function getChannelProfiles(): Collection
    {
        return $this->channelProfiles;
    }

    public function addChannelProfile(ChannelProfile $channelProfile): self
    {
        if (!$this->channelProfiles->contains($channelProfile)) {
            $this->channelProfiles[] = $channelProfile;
            $channelProfile->setChannel($this);
        }

        return $this;
    }

    public function removeChannelProfile(ChannelProfile $channelProfile): self
    {
        if ($this->channelProfiles->contains($channelProfile)) {
            $this->channelProfiles->removeElement($channelProfile);
            // set the owning side to null (unless already changed)
            if ($channelProfile->getChannel() === $this) {
                $channelProfile->setChannel(null);
            }
        }

        return $this;
    }
}
