<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class MenuBuilder configures the main navigation.
 */
class MenuBuilderSubscriber implements EventSubscriberInterface
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
            SidebarMenuEvent::class => ['onSetupNavbar', 100],
            BreadcrumbMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    /**
     * Generate the main menu.
     */
    public function onSetupNavbar(SidebarMenuEvent $event)
    {
        $event->addItem(
            new MenuItemModel('homepage', 'menu.homepage', 'homepage', [], 'fas fa-tachometer-alt')
        );
        $rh = new MenuItemModel('rh', 'menu.rh', null, [], 'fas fa-users');
        $rh->addChild(
            new MenuItemModel('employe', 'menu.employe', 'employe', [], 'fas fa-minus')
        )->addChild(
            new MenuItemModel('departement', 'Departement', 'departement', [], 'fas fa-minus')
        )->addChild(
            new MenuItemModel('contrat', 'menu.contrat', 'contrat', [], 'fas fa-minus')
        )
         /*   ->addChild(
            new MenuItemModel('config-rh', 'menu.configuration', 'config-rh', [], 'fas fa-minus')
        )*/;
        $event->addItem($rh);
        $conge = new MenuItemModel('conge', 'Conges & Absences', null, [], 'far fa-calendar-alt');
        $conge->addChild(
            new MenuItemModel('demande', 'Demande Conges', 'demande-conge', [], 'fas fa-plus'))->
        addChild(
            new MenuItemModel('demande_avalider', 'Demande a Valider', 'demande-conge-avalider', [], 'fas fa-plus'))->
        addChild(
            new MenuItemModel('Mesdemande', 'Mes Demande Conges', 'mes-demande-conge', [], 'fas fa-plus'))->
        addChild(
            new MenuItemModel('typeconge', 'Type De Conges', 'type-conge', [], 'fas fa-plus'))->addChild(
            new MenuItemModel('statistique', 'Statistque', 'type-conge', [], 'fas fa-plus'));

        $event->addItem($conge);
        $paie = new MenuItemModel('paie', 'Paie', null, [], 'far fa-credit-card');
        $event->addItem($paie);
        $paie->addChild(
            new MenuItemModel('bulletin', 'Bulletin de Paie', 'bulletin-paie', [], 'fas fa-minus'))
            ->addChild(
                new MenuItemModel('categorieregle', 'Categorie ', 'categorie-regle', [], 'fas fa-minus'))
            ->addChild(
                new MenuItemModel('reglesalaire', 'Regle des salaires', 'regle-salaire', [], 'fas fa-minus'))
            ->addChild(
                new MenuItemModel('structuresalaire', 'Structure de salaire', 'struture-salaire', [], 'fas fa-minus'))
            ->addChild(
                new MenuItemModel('advancesalaire', 'Avance sur Salaire', 'advance-salaire', [], 'fas fa-minus'));
        $formation = new MenuItemModel('form', 'Formations', null, [], 'fas fa-industry');
        $event->addItem($formation);
        $presence = new MenuItemModel('form', 'Presence', null, [], 'fas fa-industry');
        $event->addItem($presence);
        $presence->addChild(
            new MenuItemModel('presence', 'Presence', 'presence', [], 'fas fa-plus'))
            ->addChild(
                new MenuItemModel('recapitulatif', 'Recapitulatif des Presences', 'presence-recapitulatif', [], 'fas fa-plus'))
            ->addChild(
                new MenuItemModel('interface', 'Interface de Presence', 'interface-presence', [], 'fas fa-plus'));
        $event->addItem(
            new MenuItemModel('clients', 'Clients', 'customer_index', [], 'fa fa-user-check')
        );
        $event->addItem(
            new MenuItemModel('team', 'Equipe', 'team_index', [], 'fa fa-user-friends')
        );
        $recrutment = new MenuItemModel('rec', 'Recrutements', null, [], 'fas fa-industry');
        $event->addItem($recrutment);
        $temps = new MenuItemModel('temps', 'Temps & Activites', null, [], 'fas fa-industry');
        $temps->addChild(new MenuItemModel('project', 'Projects', 'project_index', [], 'fa fa-plus'))
            ->addChild(new MenuItemModel('activity', 'Activity', 'activity_index', [], 'fa fa-plus'))
            ->addChild(new MenuItemModel('mytimesheet', 'MY Timesheet', 'timesheet_user', [], 'fa fa-plus'))
            ->addChild(new MenuItemModel('timesheet', 'Timesheet', 'timesheet_index', [], 'fa fa-plus'));
        $event->addItem($temps);
        $event->addItem(
            new MenuItemModel('forms', 'menu.form', 'forms', [], 'fab fa-wpforms')
        );/**/
        $event->addItem(
            new MenuItemModel('config', 'Configuration', 'config-rh', [], 'fa fa-cog')
        );
        /*
                 $event->addItem(
                     new MenuItemModel('context', 'AdminLTE context', 'context', [], 'fas fa-code')
                 );

               /*   $demo = new MenuItemModel('demo', 'Demo', null, [], 'far fa-arrow-alt-circle-right');
                    $demo->addChild(
                        new MenuItemModel('sub-demo', 'Form - Horizontal', 'forms2', [], 'far fa-arrow-alt-circle-down')
                    )->addChild(
                        new MenuItemModel('sub-demo2', 'Form - Sidebar', 'forms3', [], 'far fa-arrow-alt-circle-up')
                    );
                    $event->addItem($demo);*/

        if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $event->addItem(
                  new MenuItemModel('logout', 'menu.logout', 'fos_user_security_logout', [], 'fas fa-sign-out-alt')
              );
        } else {
            $event->addItem(
                  new MenuItemModel('login', 'menu.login', 'fos_user_security_login', [], 'fas fa-sign-in-alt')
              );
        }

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string          $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}
