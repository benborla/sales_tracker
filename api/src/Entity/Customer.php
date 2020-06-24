<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="customer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=110, nullable=true)
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $billingState;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $billingZipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $billingCountry;

    /**
     * @ORM\Column(type="string", length=110, nullable=true)
     */
    private $shippingAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $shippingCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $shippingState;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $shippingZipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $shippingCountry;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cc = [];

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

    /**
     * @ORM\OneToMany(targetEntity=PrescriptionMedia::class, mappedBy="customer")
     */
    private $prescriptionMedias;

    public function __construct()
    {
        $this->prescriptionMedias = new ArrayCollection();
    }

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

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingState(): ?string
    {
        return $this->billingState;
    }

    public function setBillingState(?string $billingState): self
    {
        $this->billingState = $billingState;

        return $this;
    }

    public function getBillingZipCode(): ?string
    {
        return $this->billingZipCode;
    }

    public function setBillingZipCode(?string $billingZipCode): self
    {
        $this->billingZipCode = $billingZipCode;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(?string $billingCountry): self
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    public function getShippingState(): ?string
    {
        return $this->shippingState;
    }

    public function setShippingState(?string $shippingState): self
    {
        $this->shippingState = $shippingState;

        return $this;
    }

    public function getShippingZipCode(): ?string
    {
        return $this->shippingZipCode;
    }

    public function setShippingZipCode(?string $shippingZipCode): self
    {
        $this->shippingZipCode = $shippingZipCode;

        return $this;
    }

    public function getShippingCountry(): ?string
    {
        return $this->shippingCountry;
    }

    public function setShippingCountry(?string $shippingCountry): self
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    public function getCc(): ?array
    {
        return $this->cc;
    }

    public function setCc(?array $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|PrescriptionMedia[]
     */
    public function getPrescriptionMedias(): Collection
    {
        return $this->prescriptionMedias;
    }

    public function addPrescriptionMedia(PrescriptionMedia $prescriptionMedia): self
    {
        if (!$this->prescriptionMedias->contains($prescriptionMedia)) {
            $this->prescriptionMedias[] = $prescriptionMedia;
            $prescriptionMedia->setCustomer($this);
        }

        return $this;
    }

    public function removePrescriptionMedia(PrescriptionMedia $prescriptionMedia): self
    {
        if ($this->prescriptionMedias->contains($prescriptionMedia)) {
            $this->prescriptionMedias->removeElement($prescriptionMedia);
            // set the owning side to null (unless already changed)
            if ($prescriptionMedia->getCustomer() === $this) {
                $prescriptionMedia->setCustomer(null);
            }
        }

        return $this;
    }
}
