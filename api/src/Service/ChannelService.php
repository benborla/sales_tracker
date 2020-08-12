<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Channel;
use App\Entity\ChannelProfile;
use App\Entity\ChannelRole;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use App\Service\RoleKeyService;
use App\Entity\Role;

use function get_declared_classes;
use function array_filter;
use function array_map;
use function strtoupper;
use function date;
use function explode;
use function str_replace;

/**
 * @TODO
 * [ ] When creating a new channel, it should create a default profile $channel_ADMIN profile
 * [ ] When a default channel profile admin is created, it should have all the roles available for the user
 */
class ChannelService
{
    /**
     * @var string
     * @access private
     */
    private $defaultProfileName = 'Administrator';

    /**
     * @var array
     * @access private
     */
    private $generatedRoles = [];

    /**
     * @var \App\Entity\Channel
     * @access private
     */
    private $channel;

    /**
     * @var \App\Entity\User
     * @access private
     */
    private $user;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $em;

    /**
     * @var \App\Service\RoleKeyService
     * @access private
     */
    private $roleKeyService;

    public function __construct(
        TokenStorageInterface $token,
        EntityManagerInterface $em,
        RoleKeyService $roleKeyService
    ) {
        $this->user = $token->getToken()->getUser();
        $this->em = $em;
        $this->roleKeyService = $roleKeyService;
    }

    /**
     * @todo make a function that will automatically assign the admin profile to the super admin
     * @todo refactor the roles, all roles should be stored inside a table, and we just link a role to a profile, we need
     * a pivot table to do this so we can pick a specific role that a profile can have
     * @param Request $request
     * @return null|\App\Entity\Channel
     */
    public function newChannel(Request $request): ?Channel
    {
        $channel = $request->attributes->get('data');
        if (!$channel instanceof Channel) {
            return null;
        }

        $channel->setName($request->request->get('name'));
        $channel->setIsActive(true);
        $channel->setIsArchived(false);

        $this->em->persist($channel);
        $this->em->flush();

        if (!$channel->getId()) {
            throw new RuntimeException('Unable to create channel');
        }

        $request->request->set('profile', ' ' . $this->defaultProfileName);
        $channelProfile = $this->newChannelProfile($channel, $request);

        $request->request->remove('name');
        $request->request->remove('profile');

        foreach ($this->applyAllRolesForAdmin() as $idx => $role) {
            $request->request->set((string) $idx, ['id' => $role->getId()]);
        }

        $this->updateProfileRoles($request, $channelProfile);

        return $channel;
    }

    /**
     * @param Channel $channel
     * @return \App\Entity\ChannelProfile
     * @description Content-type should be application/json
     */
    public function newChannelProfile(Channel $channel, ?Request $request = null): ChannelProfile
    {
        $profileName = $this->defaultProfileName;
        $createDefaultRoles = true;

        if ($request instanceof Request) {
            $profileName = $request->get('profile') ?: $request->request->get('profile');
            $createDefaultRoles = (bool) $request->get('hasDefaultRoles');
        }

        $channelProfile = new ChannelProfile();

        $channelProfile->setChannel($channel);
        $channelProfile->setName($channel->getName() . ' ' . $profileName);

        $this->em->persist($channelProfile);
        $this->em->flush();

        return $channelProfile;
    }

    private function applyAllRolesForAdmin()
    {
        $roles = $this->em->getRepository(Role::class)->findAll();
        return $roles;

    }

    /**
     * @param Request $request
     * @access public
     * @return null|ChannelProfile
     */
    public function updateProfileRoles(
        Request $request,
        ?ChannelProfile $channelProfile = null
    ): ?ChannelProfile {
        $roles = $request->request;
        $profile = $channelProfile ?? $request->attributes->get('data');

        if (!$profile instanceof ChannelProfile) {
            return null;
        }

        foreach ($roles as $role) {
            $emRole = $this->em->find(Role::class, $role);

            if (is_null($emRole)) {
                continue;
            }

            $channelRole = new ChannelRole();
            $channelRole->setChannelProfile($profile);
            $channelRole->setRole($emRole);
            $this->em->persist($channelRole);
            $this->em->flush();
        }

        return $profile;
    }
}
