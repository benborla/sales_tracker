<?php

declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Channel;
use App\Service\UserRolesService;

use function array_merge;
use function in_array;

class AuthenticationSuccessListener
{
    private const GET_CHANNEL_COLLECTION = 'ROLE_CHANNEL_READ_COLLECTION';

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $userRoleService;

    public function __construct(UserRolesService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        $channels = [];
        $roles = [];

        if (!$user instanceof UserInterface) {
            return;
        }

        /**
         * @todo add active user checking, if the user is inactive, it should
         * not be able to login
         */
        $data['status'] = $event->getResponse()->getStatusCode();
        $data['data'] = array_merge([
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName()
        ], $this->userRoleService->getCalculatedInfo($user));

        $event->setData($data);
    }
}
