<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Role;
use App\Service\RoleKeyService;
use Doctrine\ORM\EntityManagerInterface;

use function pathinfo;

class RoleService
{
    public const PREFIX_ROLE = 'ROLE';

    /**
     * @var string
     * @access private
     */
    private $entitiesPath = 'App\Entity';

    /**
     * @var string
     * @access private
     */
    private $abstractEntity = 'App\Entity\AbstractEntity';

    /**
     * @var array
     * @access private
     */
    private $generatedRoles = [];

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $em;

    /**
     * @var \App\Service\RoleKeyService
     * @access private
     */
    private $roleKeyService;

    public function __construct(
        EntityManagerInterface $em,
        RoleKeyService $roleKeyService
    ) {
        $this->em = $em;
        $this->roleKeyService = $roleKeyService;
    }

    public function updateRoles()
    {
        $roles = $this->applyAccessRoles();
        $updatedRoles = [];
        foreach ($roles as $roleKey => $role) {
          if (is_null($this->em->getRepository(Role::class)->findOneBy(['roleKey' => $roleKey]))) {
             $entity = new Role();
              $entity->setRoleKey($roleKey);
              $entity->setMethod($role['method']);
              $entity->setDescription($role['description']);
              $entity->setEntity($role['entity']);

              $this->em->persist($entity);
              $this->em->flush();
              $updatedRoles[] = $entity;
          }
        }

        return $updatedRoles;
    }

    /**
     * @return array
     */
    private function generateKeyEntities(): array
    {
        $classes = get_declared_classes();
        $filtered = array_filter($classes, function ($class) {
            if (strpos($class, $this->entitiesPath) === 0
                && $class !== $this->abstractEntity
            ) {
                return $class;
            } else {
              return;
            }
        });

        $classes = array_map(function ($class) {
            $fragments = explode('\\', $class);
            $class = end($fragments);
            return [$class => $this->roleKeyService->getKey(self::PREFIX_ROLE, $class)];
        }, $filtered);

        return array_values($classes);
    }

    /**
     * @param mixed $key
     * @access private
     * @return array
     */
    private function applyAccessRoles(): array
    {
        $roles = [];
        foreach ($this->generateKeyEntities() as $key => $class) {
            $entity = current(array_keys($class));
            $role = current($class);

            foreach ($this->roleKeyService->getTypes() as $type) {
                $generatedRole = $this->roleKeyService->generateKey($role, $type);
                $roles[$generatedRole] = [
                    'entity' => $entity,
                    'method' => $this->roleKeyService->requestMethodMap($type),
                    'description' => $this->roleKeyService->convertToBasicDescription($generatedRole)
                ];
            }
        }

        return $roles;
    }
}
