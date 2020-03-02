<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\User;
use KevinPapst\AdminLTEBundle\Event\NavbarUserEvent;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarUserEvent;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class NavbarUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NavbarUserEvent::class => ['onShowUser', 100],
            SidebarUserEvent::class => ['onShowUser', 100],
        ];
    }

    public function onShowUser(ShowUserEvent $event)
    {
        if (null === $this->security->getUser()) {
            return;
        }

        /* @var $myUser User */
        $myUser = $this->security->getUser();

        $user = new UserModel();
        $user
            ->setId($myUser->getId())
            ->setName($myUser->getUsername())
            ->setUsername($myUser->getUsername())
            ->setIsOnline(true)
            ->setTitle('Gesp user')
            //->setAvatar($myUser->getAvatar() || '/bundles/adminlte/images/default_avatar.png')
            //->setAvatar('/bundles/adminlte/images/default_avatar.png')
            ->setMemberSince(new \DateTime());
        if (null !== $myUser->getAvatar()) {
            $user->setAvatar('uploads/'.$myUser->getAvatar());
        } else {
            $user->setAvatar('/bundles/adminlte/images/default_avatar.png');
        }
        //$event->setShowProfileLink(false);
        //$event->addLink(new NavBarUserLink('Followers', 'home'));

        $event->setUser($user);
    }
}
