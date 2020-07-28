<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\GenerateChannelService;

final class NewChannelAction
{
    public function __invoke(Request $request, GenerateChannelService $service): Channel
    {
        return $service->newChannel($request);
    }
}

