<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\CreateReactionTime;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\AbstractEntity;

/**
 * @ApiResource(
 *    collectionOperations={
 *      "get",
 *      "post",
 *      "post_create_reaction_time"={
 *          "method"="POST",
 *          "path"="/reaction_times/create",
 *          "controller"=CreateReactionTime::class
 *      }
 *    },
 *    normalizationContext={"groups"={"reaction_time:read"}},
 *    denormalizationContext={"groups"={"reaction_time:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ReactionTimeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ReactionTime extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"reaction_time:write"})
     * @Groups({"reaction_time:read"})
     */
    private $average;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"reaction_time:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reactionTimes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reaction_time:read"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAverage(): ?float
    {
        return $this->average;
    }

    public function setAverage(float $average): self
    {
        $this->average = $average;

        return $this;
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
}
