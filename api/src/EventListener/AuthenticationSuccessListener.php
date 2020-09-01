<?php

declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Channel;

use function array_keys;
use function in_array;

class AuthenticationSuccessListener
{

    private const GET_CHANNEL_COLLECTION = 'ROLE_CHANNEL_READ_COLLECTION';

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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

        foreach ($user->getUserProfiles() as $idx => $profile) {
            if ($profile->getProfile()->getChannel()->isActive() || 
              !$profile->getProfile()->getChannel()->isArchived()
            ) {
                $channels[$profile->getProfile()->getChannel()->getName()] = 1;
            }

            foreach ($profile->getProfile()->getRoles() as $roleIdx => $role) {
                $roles[$role->getRole()->getRoleKey()] = $role->getRole()->getEntity();
            }
        }

        $roles = array_keys($roles);

        // check if the user has access to read all channels
        if (in_array(self::GET_CHANNEL_COLLECTION, $roles)) {
            $channels = [];
            $channelRepo = $this->em->getRepository(Channel::class)->findAll();

            if ($channelRepo) {
                foreach ($channelRepo as $idx => $channel) {
                    if ($channel instanceof Channel) {
                        $channels[$channel->getName()] = 1;
                    }
                }
            }
        }

        /**
         * @todo add active user checking, if the user is inactive, it should
         * not be able to login
         */
        $event->roles = $user->getRoles();
        $data['code'] = $event->getResponse()->getStatusCode();
        $data['data'] = [
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'channels' => array_keys($channels),
            'roles' => $roles
        ];

        $event->setData($data);
    }
}
