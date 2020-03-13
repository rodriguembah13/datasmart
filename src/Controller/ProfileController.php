<?php

namespace App\Controller;

use App\Form\CustomerProfilType;
use App\Form\CustomerUserType;
use App\Form\EmployeeType;
use App\Form\UserProfileType;
use FOS\UserBundle\Form\Type\ProfileFormType;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request)
    {
        $tabs = [];
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if ($user->getEmployee()) {
            $employee=$user->getEmployee();
            $form = $this->createForm(EmployeeType::class, $employee);
            $formPassword = $this->createForm(ProfileFormType::class, $employee->getCompte());
            $formUser = $this->createForm(UserProfileType::class, $employee->getCompte());
            $form->handleRequest($request);
            $formPassword->handleRequest($request);
            $formUser->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            if ($formUser->isSubmitted() && $formUser->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            return $this->render('profile/index.html.twig', [
                'employee' => $employee,
                'personne' => 'employee',
                // 'strategy_digitals' => $customerUser->getStrategyDigitals(),
                'form' => $form->createView(),
                'formPassworld' => $formPassword->createView(),
                'formUser' => $formUser->createView(),
                'user' => $employee->getCompte(),
                'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'], ['Mes Strategies Digital', '#strategie']],
            ]);
        } elseif ($user->getCustomer()) {
            $customer = $user->getCustomer();
            $form = $this->createForm(CustomerProfilType::class, $customer);
            $formPassword = $this->createForm(ProfileFormType::class, $customer->getCompte());
            $formUser = $this->createForm(UserProfileType::class, $customer->getCompte());
            $form->handleRequest($request);
            $formPassword->handleRequest($request);
            $formUser->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            if ($formUser->isSubmitted() && $formUser->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            return $this->render('profile/index.html.twig', [
                'customer' => $customer,
                'personne' => 'customer',
                'strategy_digitals' => $customer->getStrategyDigitals(),
                'form' => $form->createView(),
                'formPassworld' => $formPassword->createView(),
                'formUser' => $formUser->createView(),
                'user' => $customer->getCompte(),
                'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'], ['Mes Strategies Digital', '#strategie']],
            ]);
        } elseif ($user->getCustomerUser()) {
            $personne = 'customerUser';
            $customerUser = $user->getCustomerUser();
            $form = $this->createForm(CustomerUserType::class, $customerUser);
            $formPassword = $this->createForm(ProfileFormType::class, $customerUser->getCompte());
            $formUser = $this->createForm(UserProfileType::class, $customerUser->getCompte());
            $form->handleRequest($request);
            $formPassword->handleRequest($request);
            $formUser->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            if ($formUser->isSubmitted() && $formUser->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }

            return $this->render('profile/index.html.twig', [
                'customer_user' => $customerUser,
                'user' => $customerUser->getCompte(),
                'strategy_digitals' => $customerUser->getStrategyDigitals(),
                'form' => $form->createView(),
                'formPassworld' => $formPassword->createView(),
                'formUser' => $formUser->createView(),
                'personne' => $personne,
                'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'], ['Mes Strategies Digital', '#strategie']],
            ]);
        }
    }
}
