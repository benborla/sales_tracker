<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\User;
use App\Repository\UserRepository;
use App\DataProvider\AbstractRoleCollectionCheckpoint;
use Doctrine\Common\Persistence\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\PaginatorInterface;

class UserCollectionDataProvider
{
    private $repository;
    private $collectionExtensions;

    public function __construct(
        UserRepository $repository,
        ManagerRegistry $managerRegistry,
        iterable $collectionExtensions
    ) {
        $this->repository = $repository;
        $this->managerRegistry = $managerRegistry;
        $this->collectionExtensions = $collectionExtensions;
    }

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
    ): PaginatorInterface {
        if (!$this->supports($resourceClass, $operationName, $context)) {
          return PaginatorInterface;
        }

        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);
        $queryBuilder = $repository->createQueryBuilder('e');
        $queryNameGenerator = new QueryNameGenerator();

        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);

            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
