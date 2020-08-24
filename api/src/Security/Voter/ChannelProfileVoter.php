<?php

namespace App\Security\Voter;

use App\Entity\ChannelProfile;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Security\Voter\AbstractVoter;

class ChannelProfileVoter extends AbstractVoter
{
    protected function supports($attribute, $subject): bool
    {
        return $subject instanceof ChannelProfile;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        if (!$this->supports($attribute, $subject)) {
            return false;
        }

        return parent::voteOnAttribute($attribute, $subject, $token);
    }
}
