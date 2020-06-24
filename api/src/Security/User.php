<?php

declare(strict_types=1);

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class User implements JWTUserInterface
{
    protected $email;
    protected $roles = [];
    protected $firstName;
    protected $lastName;
    protected $password;

    public function __construct(
        string $email, 
        array $roles = ['ROLE_USER'],
        string $firstName,
        string $lastName
    ) {
        $this->email = $email;
        $this->roles = $roles;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function createFromPayload(
        $username,
        array $payload
    ) {
        return new self(
            $username,
            $payload['roles'] ?? ['ROLE_USER'],
            $payload['firstName'],
            $payload['lastName'],
        );
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->password = null;
    }
}
