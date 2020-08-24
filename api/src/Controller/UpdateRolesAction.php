<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RoleService;

final class UpdateRolesAction
{
    public function __invoke(RoleService $service): array
    {
        /**
         * @todo when updating it should check if the data is already existing, if it does
         * it should only updated, if it doesn't exist, it should create a new entry
         */
        return $service->updateRoles();
    }
}
