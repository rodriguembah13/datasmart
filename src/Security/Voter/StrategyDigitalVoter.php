<?php

namespace App\Security\Voter;

use App\Entity\StrategyDigital;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StrategyDigitalVoter extends AbstractVoter
{
    public const ATTRIBUTES = [
        'view', 'edit', 'delete', 'permissions', 'details', 'comments', 'create',
    ];

    protected function supports($attribute, $subject)
    {
        if (!($subject instanceof StrategyDigital)) {
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

        if ($this->hasRolePermission($user, $attribute.'_project')) {
            return true;
        }

        return false;
    }
}
