<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ChannelService;
use App\Entity\ChannelProfile;
use Symfony\Component\HttpFoundation\Request;

final class UpdateProfileRolesAction
{
    public function __invoke(
        Request $request,
        ChannelService $service
    ): ?ChannelProfile {
        return $service->updateProfileRoles($request);
    }
}

