<?php

declare(strict_types=1);

namespace App\Security\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Service\UserRolesService;

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

    /**
     * @var \App\Service\UserRolesService
     */
    private $userRoleService;

    public function __construct(UserRolesService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
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
        $this->userRoleService->setUser($token->getUser());
        $roles = $this->userRoleService->getRoles();
        $entity = $this->getEntityName($subject, $attribute);

        if (is_null($entity)) {
            return false;
        }

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $attribute = self::ROLE_KEY . '_' . $entity . '_' . $attribute;

        return in_array($attribute, $roles);
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
