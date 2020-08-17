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

/**
 * @TODO
 * [ ] Update voter to retrieve new format of roles
 * [ ] GET COLLECTION should be moved to a data provider, it should not be handled here
 */
abstract class AbstractVoter extends Voter
{
    protected const ROLE_KEY = 'ROLE';
    private const CACHE_KEY = 'user.stored.roles';
    private const CACHE_EXPIRY = 86400; // 24 hours
    private const CACHE_NAMESPACE = 'app';
    private const IS_DEV = 'dev';

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
        if (!$rolesCache->isHit() || $this->appKernel->getEnvironment() === self::IS_DEV) {
            foreach ($user->getUserProfiles() as $profile) {
                $channel = strtoupper($profile->getProfile()->getChannel()->getName());
                foreach ($profile->getProfile()->getRoles() as $role) {
                    $roles[] = $role->getRole()->getRoleKey();
                }
            }
            $rolesCache->set(['roles' => $roles, 'channel' => $channel]);
            $cache->save($rolesCache);
        } else {
            $cacheItem = $cache->getItem(self::CACHE_KEY)->get();
            $roles = $cacheItem['roles'] ?? null;
            $channel = $cacheItem['channel'] ?? null;
        }

        $attribute = self::ROLE_KEY . '_' . $entity . '_' . $attribute;
        // dump($attribute, in_array($attribute, $roles));die;

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
