<?php

namespace App\Security\Voter;

use App\Entity\CustomerUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerUserVoter extends AbstractVoter
{
    public const ATTRIBUTES = [
        'view', 'edit', 'delete', 'permissions', 'details', 'comments','create'
    ];

    protected function supports($attribute, $subject)
    {
        if (!($subject instanceof CustomerUser)) {
            return false;
        }
        if (!in_array($attribute, self::ATTRIBUTES)) {
            false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->hasRolePermission($user, $attribute.'_customeruser')) {
            return true;
        }

        return false;
    }
}
