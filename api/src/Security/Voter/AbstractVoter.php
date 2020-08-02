<?php

declare(strict_types=1);

namespace App\Security\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpKernel\KernelInterface;

use function strtoupper;
use function get_class;
use function explode;

abstract class AbstractVoter extends Voter
{
    protected const ROLE_KEY = 'ROLE';
    private const CACHE_KEY = 'user.stored.roles';
    private const CACHE_EXPIRY = 86400; // 24 hours
    private const CACHE_NAMESPACE = 'sales_tracker';

    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    /**
     * @param mixed $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @access protected
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $roles = [];
        $channel = null;
        $entity = $this->getEntityName($subject, $attribute);
        $cache = new FilesystemAdapter(self::CACHE_NAMESPACE, self::CACHE_EXPIRY, $this->getCacheDir());

        if (is_null($entity)) {
            return false;
        }

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $rolesCache = $cache->getItem(self::CACHE_KEY);
        if (!$rolesCache->isHit()) {
            foreach ($user->getUserProfiles() as $profile) {
                $channel = strtoupper($profile->getProfile()->getChannel()->getName());
                foreach ($profile->getProfile()->getRoles() as $role) {
                    $roles[] = $role->getRoleKey();
                }
            }
            $rolesCache->set(['roles' => $roles, 'channel' => $channel]);
            $cache->save($rolesCache);
        } else {
            $cacheItem = $cache->getItem(self::CACHE_KEY)->get();
            $roles = $cacheItem['roles'] ?? null;
            $channel = $cacheItem['channel'] ?? null;
        }

        $attribute = explode('_', $attribute);
        $attribute = end($attribute);
        $attribute = self::ROLE_KEY . '_' . $channel . '_' . $entity . '_' . $attribute;

        return in_array($attribute, $roles);
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
     * @param mixed $subject
     * @access private
     * @return string
     */
    private function getEntityName($subject, $default = null): string
    {
        if ($subject instanceof Paginator) {
            $entity = explode('_', $default);
            return current($entity);
        } else {
            $namespaceFragments = explode('\\', get_class($subject));
            return strtoupper(end($namespaceFragments));
        }
    }
}
