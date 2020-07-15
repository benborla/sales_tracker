<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InformationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=InformationRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Information
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="information")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:write"})
     * @MaxDepth(1)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=110, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $billingState;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $billingZipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $billingCountry;

    /**
     * @ORM\Column(type="string", length=110, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $shippingAddress;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $shippingCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $shippingState;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $shippingZipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $shippingCountry;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user", "user:write"})
     */
    private $cc;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getBillingState(): ?string
    {
        return $this->billingState;
    }

    public function setBillingState(?string $billingState): self
    {
        $this->billingState = $billingState;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getBillingZipCode(): ?string
    {
        return $this->billingZipCode;
    }

    public function setBillingZipCode(?string $billingZipCode): self
    {
        $this->billingZipCode = $billingZipCode;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(?string $billingCountry): self
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getShippingState(): ?string
    {
        return $this->shippingState;
    }

    public function setShippingState(?string $shippingState): self
    {
        $this->shippingState = $shippingState;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getShippingZipCode(): ?string
    {
        return $this->shippingZipCode;
    }

    public function setShippingZipCode(?string $shippingZipCode): self
    {
        $this->shippingZipCode = $shippingZipCode;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getShippingCountry(): ?string
    {
        return $this->shippingCountry;
    }

    public function setShippingCountry(?string $shippingCountry): self
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function setCc(?string $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
