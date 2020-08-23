<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\User;
use App\Repository\UserRepository;
use App\DataProvider\AbstractRoleCollectionCheckpoint;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserCollectionDataProvider extends AbstractRoleCollectionCheckpoint
{
    private $repository;

    public function __construct(
        UserRepository $repository,
        ManagerRegistry $managerRegistry,
        iterable $collectionExtensions
    ) {
        $this->repository = $repository;
        parent::__construct($managerRegistry, $collectionExtensions);
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     *
     * @return bool
     */
    public function supports(
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ): bool {
        return User::class === $resourceClass;
    }

    public function getCollection(
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ) {
        if (!$this->supports($resourceClass, $operationName, $context)) {
          return;
        }

        return parent::getCollection($resourceClass, $operationName, $context);
    }
}
