<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\CalculateRoles;

final class GetRolesController
{
    /**
     * __invoke
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Service\CalculateRoles $calculateRoles
     * @return void
     */
    public function __invoke(Request $request, CalculateRoles $calculateRoles)
    {
        return new JsonResponse($calculateRoles->getRoles());
    }
    
}
