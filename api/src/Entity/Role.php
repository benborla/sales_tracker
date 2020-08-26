<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UpdateRolesAction;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    attributes={"security"="is_granted('ROLE_USER')"},
 *    collectionOperations={
 *        "post" = { "security_post_denormalize" = "is_granted('CREATE', object)" },
 *        "get",
 *        "get_update_roles"={
 *            "method"="GET",
 *            "controller"=UpdateRolesAction::class,
 *            "path"="roles/push"
 *        }
 *    },
 *   itemOperations={
 *        "get" = { "security" = "is_granted('READ', object)" },
 *        "put" = { "security" = "is_granted('UPDATE', object)" },
 *        "patch" = { "security" = "is_granted('UPDATE', object)" },
 *        "delete" = { "security" = "is_granted('DELETE', object)" }
 *     },
 * )
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    public const REL_PROPERTY_KEY = '';

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

    /**
     * @Groups({"user:collection:get", "user:item:get", "channelProfile:read"})
     */
    public function getRoleKey(): ?string
    {
        return $this->roleKey;
    }

    public function setRoleKey(string $roleKey): self
    {
        $this->roleKey = $roleKey;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function setEntity(?string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
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
