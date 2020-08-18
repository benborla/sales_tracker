<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\Information;
use App\Repository\InformationRepository;
use App\DataProvider\AbstractRoleCollectionCheckpoint;
use Doctrine\Common\Persistence\ManagerRegistry;

class InformationCollectionDataProvider extends AbstractRoleCollectionCheckpoint
{
    private $repository;

    public function __construct(
        InformationRepository $repository,
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
        return Information::class === $resourceClass;
    }

    public function getCollection(
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ) {
        return parent::getCollection($resourceClass, $operationName, $context);
    }
}
