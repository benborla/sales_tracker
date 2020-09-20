<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Doctrine\CollectionRoleCheckpointExtension;
use ApiPlatform\Core\DataProvider\PaginatorInterface;

abstract class AbstractRoleCollectionCheckpoint implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var \Doctrine\Common\Persistence\ManagerRegistry $managerRegistry */
    private $managerRegistry;

    /**
     * @var array
     */
    private $collectionExtensions;

    public function __construct(
        ManagerRegistry $managerRegistry,
        iterable $collectionExtensions
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->collectionExtensions = $collectionExtensions;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     *
     * @return array|\Traversable
     * @throws \ApiPlatform\Core\Exception\ResourceClassNotSupportedException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): PaginatorInterface
    {
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);

        if (null === $manager) {
            throw new ResourceClassNotSupportedException();
        }

        $repository = $manager->getRepository($resourceClass);

        if (!method_exists($repository, 'createQueryBuilder')) {
            throw new RuntimeException('The repository class must have a "createQueryBuilder" method.');
        }

        /** @var \Doctrine\Orm\QueryBuilder $queryBuilder */
        $queryBuilder = $repository->createQueryBuilder('o');
        $queryNameGenerator = new QueryNameGenerator();

        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
