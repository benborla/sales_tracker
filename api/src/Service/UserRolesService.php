<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Entity\User;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Channel;

use function in_array;
use function array_unique;

class UserRolesService
{
    private const CACHE_KEY = 'user.stored.roles';
    private const CACHE_EXPIRY = 86400; // 24 hours
    private const CACHE_NAMESPACE = 'app';
    private const IS_DEV = 'dev';
    private const GET_CHANNEL_COLLECTION = 'ROLE_CHANNEL_READ_COLLECTION';

    /**
     * @var \App\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $em;

    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel, EntityManagerInterface $em)
    {
        $this->appKernel = $appKernel;
        $this->em = $em;
    }

    /**
     * @param \App\Entity\User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    } // End function setUser

    /**
     * @return \App\Entity\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = [];
        $user = $this->getUser();
        $channel = null;
        $cache = new FilesystemAdapter(
            self::CACHE_NAMESPACE,
            self::CACHE_EXPIRY,
            $this->getCacheDir());

        $rolesCache = $cache->getItem(self::CACHE_KEY);
        if (!$rolesCache->isHit() || $this->appKernel->getEnvironment() === self::IS_DEV) {
            foreach ($user->getUserProfiles() as $profile) {
                $channel = strtoupper($profile->getProfile()->getChannel()->getName());
                foreach ($profile->getProfile()->getRoles() as $role) {
                    $roles[] = $role->getRole()->getRoleKey();
                }
            }
            $rolesCache->set(['roles' => $roles]);
            $cache->save($rolesCache);
        } else {
            $cacheItem = $cache->getItem(self::CACHE_KEY)->get();
            $roles = $cacheItem['roles'] ?? null;
        }

        return $roles;
    }


    /**
     * @access private
     * @return string
     */
    private function getCacheDir(): string
    {
        return $this->appKernel->getProjectDir() .'/var/' . $this->appKernel->getEnvironment() . '/cache';
    }

    /**
     * @param null|\App\Entity\User $user
     * @return array
     */
    public function getCalculatedInfo(?User $user = null): array
    {
        $info = ['channels' => [], 'roles' => []];

        if (!$user instanceof User) {
            return $info;
        }

        $channels = [];
        $roles = [];

        foreach ($user->getUserProfiles() as $idx => $profile) {
            if ($profile->getProfile()->getChannel()->isActive() || 
              !$profile->getProfile()->getChannel()->isArchived()
            ) {
                $channels[] = $profile->getProfile()->getChannel()->getName();
            }

            foreach ($profile->getProfile()->getRoles() as $roleIdx => $role) {
                $roles[] = $role->getRole()->getRoleKey();
            }
        }

        // check if the user has access to read all channels
        if (in_array(self::GET_CHANNEL_COLLECTION, $roles)) {
            $channels = [];
            $channelRepo = $this->em->getRepository(Channel::class)->findAll();

            if ($channelRepo) {
                foreach ($channelRepo as $idx => $channel) {
                    if ($channel instanceof Channel) {
                        $channels[] = $channel->getName();
                    }
                }
            }
        }

        return [
            'channels' => array_unique($channels),
            'roles' => array_unique($roles)
        ];
    }
}
