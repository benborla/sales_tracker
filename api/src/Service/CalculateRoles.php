<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ContainerInterface;

class CalculateRoles
{
    /**
     * @var \App\Entity\User
     */
    private $user;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var array
     */
    private $availableRoles = []; 

    public function __construct(
      TokenStorageInterface $tokenStorage,
      array $roles
    ) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->roles = $this->formatRoles($roles);
    }

    /**
     * @return void
     */
    public function getRoles()
    {
        $calculatedRoles = $this->calculate();

        // by default we should remove ROLE_USER, since this will be an internal use only
        unset($calculatedRoles['ROLE_USER']);

        return $calculatedRoles;
    }

    private function getHighestRole()
    {
        $currentHighestOrder = 0;

        foreach ($this->user->getRoles() as $role) {
            foreach ($this->roles as $roleKey => $roleDetails) {
                if ($role === $roleKey) {
                    if ($currentHighestOrder <= $roleDetails['order']) {
                        $currentHighestOrder = $roleDetails['order'];
                    }
                }
            }
        }

        return $currentHighestOrder;
    }

    /**
     * @param mixed $role
     */
    private function calculate()
    {
        $highestRole = $this->getHighestRole();
        $calculatedRoles = [];

        foreach ($this->roles as $roleKey => $roleDetails) {
            if ($highestRole <= $roleDetails['order']) {
                $calculatedRoles[$roleKey] = $roleDetails['role'];
            }
        }

        return $calculatedRoles;
    }

    /**
     * @return array
     */
    private function formatRoles(array $roles)
    {
        $newRoles = [];
        foreach ($roles as $idx => $role) {
          $newRoles[$role['key']] = [
              'role' => $role['value'],
              'order' => $role['order']
          ];
        }

        return $newRoles;
    }
}
