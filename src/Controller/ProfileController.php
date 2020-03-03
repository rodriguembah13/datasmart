<?php

namespace App\Controller;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends AbstractController
{
    private $userManager;

    /**
     * ProfileController constructor.
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $tabs = [];
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if ($user->getEmployee()) {
            return $this->render('profile/index.html.twig', [
                'user' => $user,
                'personne' => 'employe',
            ]);
        } elseif ($user->getCustomer()) {
            $customer = $user->getCustomer();

            return $this->render('profile/index.html.twig', [
                'user' => $user,
                'personne' => 'customer',
                'strategy_digitals' => $customer->getStrategyDigitals(),
                'tabs' => [['Information Personnel','#personnelle'], ['Mon Compte','#compte'], ['Change Password','#password'], ['Mes Strategies Digital','#strategie']],
            ]);
        } elseif ($user->getCustomerUser()) {
            $personne = 'customerUser';

            return $this->render('profile/index.html.twig', [
                'user' => $user,
                'personne' => $personne,
            ]);
        }
    }
}
