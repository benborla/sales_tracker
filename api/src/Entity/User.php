<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\AbstractEntity;
use App\Entity\Traits\TimestampableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *    forceEager=false,  
 *    collectionOperations={
 *      "get"={"security"="is_granted('ROLE_ADMIN')", "normalization_context"={"groups"="user:collection:get"}},
 *      "post"
 *    },
 *    itemOperations={
 *      "get"={"normalization_context"={"groups"="user:item:get"}},
 *      "post",
 *      "put",
 *      "patch",
 *      "delete"
 *    },
 *    normalizationContext={"groups"={"user:read", "user"}},
 *    denormalizationContext={"groups"={"user:write"}},
 * )
 * @ApiFilter(DateFilter::class, properties={"createdAt", "updatedAt"})
 * @ApiFilter(SearchFilter::class, properties={
 *    "id": "exact", "email": "partial", "firstName": "partial",
 *    "middleName": "partial", "lastName": "partial", "accountType": "exact"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"})
 * @ORM\HasLifecycleCallbacks
 */
class User extends AbstractEntity implements UserInterface, BlameableInterface
{
    use TimestampableTrait;
    use BlameableTrait;

    public const TYPE_STAFF = 'staff';
    public const TYPE_CUSTOMER = 'customer';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @Groups({"user:write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=30)
     */
    private $firstName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=30)
     */
    private $lastName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $middleName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $accountType = 'customer';

    /**
     * @ORM\OneToOne(targetEntity=Information::class, mappedBy="user", cascade={"persist", "remove"})
     * @Groups({"user:write", "user:read", "user"})
     * @MaxDepth(1)
     */
    private $information;

    public function __construct()
    {
        //...
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * toArray
     *
     * @access public
     * @return array
     */
    public function toArray()
    {
        $user = \get_object_vars($this);
        unset($user['password']);

        return $user;
    } // End function toArray


    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
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

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getAccountType(): ?string
    {
        return \ucfirst($this->accountType);
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = \strtolower($accountType);

        return $this;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getFullName(): string
    {
        $middleInitial = $this->middleName ? ' ' . strtoupper(substr($this->middleName, 0, 1)) . '.' : '';
        return "$this->lastName, $this->firstName" . $middleInitial;
    }

    /**
     * @Groups({"user:collection:get", "user:item:get"})
     */
    public function getInformation(): ?Information
    {
        return $this->information;
    }

    public function setInformation(Information $information): self
    {
        $this->information = $information;

        // set the owning side of the relation if necessary
        if ($information->getUser() !== $this) {
            $information->setUser($this);
        }

        return $this;
    }
}
