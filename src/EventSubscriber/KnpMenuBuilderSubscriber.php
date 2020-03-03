<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class KnpMenuBuilderSubscriber configures the main navigation utilizing the KnpMenuBundle.
 */
class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    /**
     * Generate the main menu.
     */
    public function onSetupNavbar(KnpMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild(
            'menu-label',
            ['label' => 'Main Navigation', 'childOptions' => $event->getChildOptions()]
        )->setAttribute('class', 'header');

        $menu->addChild(
            'homepage',
            ['route' => 'homepage', 'label' => 'menu.homepage', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fas fa-tachometer-alt');
        $menu->addChild(
            'menu-customer',
            ['label' => 'Customer', 'childOptions' => $event->getChildOptions()]
        )->setAttribute('class', 'header');

        $menu->addChild(
            'customer_user',
            ['route' => 'customer_user_index', 'label' => 'Customer User', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fa fa-users');
        $menu->addChild(
            'strategy_digital',
            ['route' => 'strategy_digital_index', 'label' => 'Strategy Digital', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fab fa-wpforms');

        /* $menu->addChild(
             'managecustomer',
             ['label' => 'Manage Customer', 'childOptions' => $event->getChildOptions(), 'options' => ['branch_class' => 'treeview']]
         )->setLabelAttribute('icon', 'far fa-arrow-alt-circle-right');*/
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu->addChild(
            'menu-admin',
            ['label' => 'Administration', 'childOptions' => $event->getChildOptions()]
        )->setAttribute('class', 'header');
            $menu->addChild(
            'customers',
            ['route' => 'customer_index', 'label' => 'Customer', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fa fa-user-friends');
            $menu->addChild(
            'user',
            ['route' => 'user_index', 'label' => 'user', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fa fa-users-cog');
            if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
                $menu->addChild(
            'employee',
            ['route' => 'employee_index', 'label' => 'employee', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fa fa-user-cog');
                $menu->addChild(
            'permissions',
            ['route' => 'role_permission_index', 'label' => 'permissions', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fab fa-wpforms');
            }
        }
        /*$menu->addChild(
            'context',
            ['route' => 'context', 'label' => 'AdminLTE context', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fas fa-code');

        $menu->addChild(
            'demo',
            ['label' => 'Demo', 'childOptions' => $event->getChildOptions(), 'options' => ['branch_class' => 'treeview']]
        )->setLabelAttribute('icon', 'far fa-arrow-alt-circle-right');

        $menu->getChild('demo')->addChild(
            'sub-demo',
            ['route' => 'forms2', 'label' => 'Form - Horizontal', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'far fa-arrow-alt-circle-down');

        $menu->getChild('demo')->addChild(
            'sub-demo2',
            ['route' => 'forms3', 'label' => 'Form - Sidebar', 'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'far fa-arrow-alt-circle-up');*/

        if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild(
                'logout',
                ['route' => 'fos_user_security_logout', 'label' => 'menu.logout', 'childOptions' => $event->getChildOptions()]
            )->setLabelAttribute('icon', 'fas fa-sign-out-alt');
        } else {
            $menu->addChild(
                'login',
                ['route' => 'fos_user_security_login', 'label' => 'menu.login', 'childOptions' => $event->getChildOptions()]
            )->setLabelAttribute('icon', 'fas fa-sign-in-alt');
        }
    }
}
