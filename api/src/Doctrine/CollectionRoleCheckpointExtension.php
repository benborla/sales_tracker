<?php

declare(strict_types=1);

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Information;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use App\Service\UserRolesService;

use function strtoupper;
use function sprintf;
use function explode;
use function end;
use function in_array;
use function preg_replace;

final class CollectionRoleCheckpointExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private const ROLE_COLLECTION = 'ROLE_%s_READ_COLLECTION';

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private $security;

    /**
     * @var \App\Service\UserRolesService
     */
    private $userRoleService;

    public function __construct(Security $security, UserRolesService $userRoleService)
    {
        $this->security = $security;
        $this->userRoleService = $userRoleService;
        $this->userRoleService->setUser($this->security->getUser());
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function getEntity(string $resourceClass): string
    {
        $fragments = explode('\\', $resourceClass);
        return end($fragments);
    }

    public function collectionRole(string $entity): string
    {
        $entity = strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $entity));
        return sprintf(self::ROLE_COLLECTION, strtoupper($entity));
    }

    private function hasAccessToCollection(string $role, array $roles): bool
    {
        return in_array($role, $roles);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        $entity = $this->getEntity($resourceClass);
        $role = $this->collectionRole($entity);
        $user = $this->security->getUser();
        $roles = $this->userRoleService->getRoles();
        $entityRelAnchoredPropertyKey = $resourceClass::REL_PROPERTY_KEY ?: null;

        if (!$this->hasAccessToCollection($role, $roles)) {
            $rootAlias = $queryBuilder->getRootAliases()[0];

            if (!is_null($entityRelAnchoredPropertyKey)) {
                $queryBuilder->andWhere(sprintf("%s.$entityRelAnchoredPropertyKey = :current_user", $rootAlias));
                $queryBuilder->setParameter('current_user', $user->getId());
            } else {
                $queryBuilder->andWhere(sprintf('%s.id = :fake_id', $rootAlias));
                $queryBuilder->setParameter('fake_id', 'asdf');
            }
        }
    }
}
