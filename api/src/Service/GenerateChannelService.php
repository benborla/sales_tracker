<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Channel;
use App\Entity\ChannelProfile;
use App\Entity\ChannelRole;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

use function get_declared_classes;
use function array_filter;
use function array_map;
use function strtoupper;
use function date;

class GenerateChannelService
{
    /**
     * @var array
     * @access private
     */
    private $defaultRoles = [
        '%s_READ',
        '%s_WRITE',
    ];

    /**
     * @var string
     * @access private
     */
    private $entitiesPath = 'App\Entity';

    /**
     * @var string
     * @access private
     */
    private $abstractEntity = 'App\Entity\AbstractEntity';

    /**
     * @var string
     * @access private
     */
    private $defaultProfileName = 'ADMIN';

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
     * @TODO
     * [x] map all entity files on $entitiesPath, this will be used as a prefix to your roles,like
     * User_READ, User_WRITE, ChannelProfile_READ, ChannelProfile_WRITE
     * [x] Convert entity prefix into snake_case
     * [x] Once compiled, store them to $generatedRoles, this will be used later on
     * [x] Save the Channel entity
     * [x] Generate a default Channel Profile which will be named *Channel_NAME_{$defaultProfileName}*
     * [x] Store the generated roles should be linked to Channel Profile
     * [ ] Create a function that creates a profile, args will be: Channel ID and the profile name
     * [ ] create a group in Channel entity and put this on each Profile and Role entity, so it will be included in the respnse
     */

    public function __construct(TokenStorageInterface $token, EntityManagerInterface $em)
    {
        $this->user = $token->getToken()->getUser();
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return null|\App\Entity\Channel
     */
    public function newChannel(Request $request): ?Channel
    {
        $channel = $request->attributes->get('data');
        if (!$channel instanceof Channel) {
            return null;
        }

        $channel->setIsActive(true);
        $channel->setIsArchived(false);

        $this->em->persist($channel);
        $this->em->flush();

        if (!$channel->getId()) {
            throw new RuntimeException('Unable to create channel');
        }

        $this->newChannelRoles(
          $this->newChannelProfile($channel),
          $this->applyAccessRoles($channel->getName())
        );

        return $channel;
    }

    /**
     * @param Channel $channel
     * @return \App\Entity\ChannelProfile
     */
    public function newChannelProfile(Channel $channel): ChannelProfile
    {
        $channelProfile = new ChannelProfile();

        $channelProfile->setChannel($channel);
        $channelProfile->setName(strtoupper($channel->getName() . '_' . $this->defaultProfileName));

        $this->em->persist($channelProfile);
        $this->em->flush();

        return $channelProfile;
    }

    /**
     * newChannelRoles
     *
     * @param ChannelProfile $channelProfile
     * @param array $roles
     * @return self
     */
    private function newChannelRoles(ChannelProfile $channelProfile, array $roles): self
    {
        foreach ($roles as $key => $name) {
            $channelRole = new ChannelRole();
            $channelRole->setRoleKey($key);
            $channelRole->setRoleName($name);
            $channelRole->setChannelProfile($channelProfile);

            $this->em->persist($channelRole);
            $this->em->flush();
        }

        return $this;
    }

    /**
     * @return array
     */
    private function generateKeyEntities($key): array
    {
        $classes = get_declared_classes();
        $filtered = array_filter($classes, function ($class) {
            if (strpos($class, $this->entitiesPath) === 0
                && $class !== $this->abstractEntity
            ) {
                return $class;
            } else {
              return;
            }
        });

        $classes = array_map(function ($class) use ($key) {
            $class = explode('\\', $class);
            $class = (new CamelCaseToSnakeCaseNameConverter)->normalize(end($class));
            return strtoupper($key) . '_' . strtoupper($class);
        }, $filtered);

        return $classes;
    }

    /**
     * @param mixed $key
     * @access private
     * @return array
     */
    private function applyAccessRoles($key): array
    {
        $roles = [];
        foreach ($this->generateKeyEntities($key) as $role) {
            foreach ($this->defaultRoles as $roleFunction) {
                $roleKey = sprintf($roleFunction, $role);
                $roleName = ucwords(str_replace('_', ' ', strtolower($roleKey)));
                $roles[$roleKey] = $roleName;
            }
        }

        return $roles;
    }
}
