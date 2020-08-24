<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\Channel;
use App\Repository\ChannelRepository;
use App\DataProvider\AbstractRoleCollectionCheckpoint;
use Doctrine\Common\Persistence\ManagerRegistry;

class ChannelCollectionDataProvider extends AbstractRoleCollectionCheckpoint
{
    private $repository;

    public function __construct(
        ChannelRepository $repository,
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
        return Channel::class === $resourceClass;
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