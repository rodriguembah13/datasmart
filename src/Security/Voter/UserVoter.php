<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends AbstractVoter
{
    public const VIEW = 'view';
    public const EDIT = 'edit';
    public const DELETE = 'delete';
    public const PASSWORD = 'password';
    public const ROLES = 'roles';
    public const TEAMS = 'teams';
    public const PREFERENCES = 'preferences';
    public const API_TOKEN = 'api-token';
    public const HOURLY_RATE = 'hourly-rate';

    public const ALLOWED_ATTRIBUTES = [
        self::VIEW,
        self::EDIT,
        self::ROLES,
        self::TEAMS,
        self::PASSWORD,
        self::DELETE,
        self::PREFERENCES,
        self::API_TOKEN,
        self::HOURLY_RATE,
    ];

    /**
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!($subject instanceof User)) {
            return false;
        }

        if (!in_array($attribute, self::ALLOWED_ATTRIBUTES)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param User   $subject
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!($user instanceof User)) {
            return false;
        }

        $permission = '';

        switch ($attribute) {
            // special case for the UserController
            case self::DELETE:
                if ($subject->getId() === $user->getId()) {
                    return false;
                }

                return $this->hasRolePermission($user, 'delete_user');

            case self::VIEW:
            case self::EDIT:
            case self::PREFERENCES:
            case self::PASSWORD:
            case self::API_TOKEN:
            case self::ROLES:
            case self::TEAMS:
            case self::HOURLY_RATE:
                $permission .= $attribute;
                break;

            default:
                return false;
        }

        $permission .= '_';

        // extend me for "team" support later on
        if ($subject->getId() == $user->getId()) {
            $permission .= 'own';
        } else {
            $permission .= 'other';
        }

        $permission .= '_profile';

        return $this->hasRolePermission($user, $permission);
    }
}
