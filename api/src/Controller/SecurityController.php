<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\UserRolesService;

use function array_merge;

/**
 * SecurityController
 *
 * @uses AbstractController
 * @package 
 * @version $id$
 * @copyright 2020 Blennd
 * @author Trevor Suarez <rican7@gmail.com>
 * @license PHP Version 5.4 {@link http://www.php.net/license/}
 */
class SecurityController extends AbstractController
{
    /**
     * @access public
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function user(UserRolesService $userRoleService)
    {
        $user = $this->getUser();
        $calculatedInfo = $userRoleService->getCalculatedInfo($user);

        return new JsonResponse(array_merge(
            $this->getUser()->toArray(),
            $calculatedInfo
        ));
    }
}
