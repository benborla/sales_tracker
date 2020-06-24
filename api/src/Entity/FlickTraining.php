<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractEntity;
use App\Controller\CreateFlickTraining;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Traits\TimestampableTrait;

/**
 * @ApiResource(
 *    collectionOperations={
 *      "get",
 *      "post",
 *      "post_create_flick_training"={
 *          "method"="POST",
 *          "path"="/flick_trainings/create",
 *          "controller"=CreateFlickTraining::class
 *      }
 *    },
 *    normalizationContext={"groups"={"flick_training:read"}},
 *    denormalizationContext={"groups"={"flick_training:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FlickTrainingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class FlickTraining extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="flickTrainings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"flick_training:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     * @Groups({"flick_training:write"})
     * @Groups({"flick_training:read"})
     */
    private $score;

    /**
     * @ORM\Column(type="float")
     * @Groups({"flick_training:write"})
     * @Groups({"flick_training:read"})
     */
    private $accuracy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"flick_training:read"})
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
