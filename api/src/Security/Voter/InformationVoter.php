<?php

namespace App\Security\Voter;

use App\Entity\Information;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Security\Voter\AbstractVoter;

use function strtoupper;

class InformationVoter extends AbstractVoter
{
    protected function supports($attribute, $subject): bool
    {
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return parent::voteOnAttribute($attribute, $subject, $token);
    }
}
