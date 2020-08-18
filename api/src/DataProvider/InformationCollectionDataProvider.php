<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterExtension;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Information;
use App\Repository\InformationRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\EagerLoadingExtension;
use App\Doctrine\InformationExtension;

final class InformationCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var \Doctrine\Common\Persistence\ManagerRegistry $managerRegistry */
    private $managerRegistry;

    /** @var \App\Repository\InformationRepository */
    private $informationRepository;

    /**
     * @var array
     */
    private $collectionExtensions;

    public function __construct(
        ManagerRegistry $managerRegistry,
        InformationRepository $informationRepository,
        iterable $collectionExtensions
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->informationRepository = $informationRepository;
        $this->collectionExtensions = $collectionExtensions;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Information::class === $resourceClass;
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
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
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

            if ($extension instanceof QueryResultCollectionExtensionInterface &&
                $extension->supportsResult($resourceClass, $operationName)) {
                /** @var \ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator $collections */
                $collections = $extension->getResult($queryBuilder);

                return $collections;
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
