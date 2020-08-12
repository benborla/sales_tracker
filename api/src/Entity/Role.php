<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UpdateRolesAction;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    collectionOperations={
 *        "post",
 *        "get"={
 *            "controller"=UpdateRolesAction::class
 *        }
 *    }
 * )
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"channel", "channelProfile"})
     */
    private $roleKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"channel", "channelProfile"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"channel", "channelProfile"})
     */
    private $entity;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"channel", "channelProfile"})
     */
    private $method;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function setEntity(?string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): self
    {
        $this->method = $method;

        return $this;
    }
}
