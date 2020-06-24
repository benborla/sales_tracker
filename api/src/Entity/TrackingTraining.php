<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractEntity;
use App\Entity\Traits\TimestampableTrait;
use App\Controller\CreateTrackingTraining;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    collectionOperations={
 *      "get",
 *      "post",
 *      "post_create_tracking_training"={
 *          "method"="POST",
 *          "path"="/tracking_trainings/create",
 *          "controller"=CreateTrackingTraining::class
 *      }
 *    },
 *    normalizationContext={"groups"={"tracking_training:read"}},
 *    denormalizationContext={"groups"={"tracking_training:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TrackingTrainingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TrackingTraining extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trackingTrainings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"tracking_training:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tracking_training:read"})
     * @Groups({"tracking_training:write"})
     */
    private $score;

    /**
     * @ORM\Column(type="float")
     * @Groups({"tracking_training:read"})
     * @Groups({"tracking_training:write"})
     */
    private $accuracy;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"tracking_training:read"})
     * @Groups({"tracking_training:write"})
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"tracking_training:read"})
     * @Groups({"tracking_training:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"tracking_training:read"})
     */
    private $createdAt;

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

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getAccuracy(): ?float
    {
        return $this->accuracy;
    }

    public function setAccuracy(float $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
