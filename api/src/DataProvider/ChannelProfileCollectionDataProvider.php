<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\ChannelProfile;
use App\Repository\ChannelProfileRepository;
use App\DataProvider\AbstractRoleCollectionCheckpoint;
use Doctrine\Common\Persistence\ManagerRegistry;
use ApiPlatform\Core\DataProvider\PaginatorInterface;

class ChannelProfileCollectionDataProvider extends AbstractRoleCollectionCheckpoint
{
    private $repository;

    public function __construct(
        ChannelProfileRepository $repository,
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
        return ChannelProfile::class === $resourceClass;
    }

    public function getCollection(
        string $resourceClass,
        string $operationName = null,
        array $context = []
    ): PaginatorInterface {
        if (!$this->supports($resourceClass, $operationName, $context)) {
          return PaginatorInterface;
        }

        return parent::getCollection($resourceClass, $operationName, $context);
    }
}
