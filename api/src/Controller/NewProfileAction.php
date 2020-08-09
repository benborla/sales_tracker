<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\ChannelProfile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ChannelService;
use Symfony\Component\Routing\Annotation\Route;

final class NewProfileAction
{
    public function __invoke(
        Channel $data,
        Request $request, 
        ChannelService $service
    ): ChannelProfile {
        return $service->newChannelProfile($data, $request);
    }
}

