<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RoleService;

final class UpdateRolesAction
{
    public function __invoke(RoleService $service): array
    {
        return $service->updateRoles();
    }
}
