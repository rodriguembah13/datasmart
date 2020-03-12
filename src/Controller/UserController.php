<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\CustomerUser;
use App\Entity\Employee;
use App\Entity\User;
use App\Form\UserCustomerType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/user")
 * @Security("is_granted('view_user')")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @Security("is_granted('view_user')")
     */
    public function index(UserRepository $userRepository, EntityManagerInterface $manager, PaginatorInterface $paginator, Request $request): Response
    {
        $dql = 'SELECT a FROM App\Entity\User a';
        $query = $manager->createQuery($dql);
        $paginator = $paginator->paginate($query, $request->query->getInt('page', 1), 12);

        return $this->render('user/index.html.twig', [
            'users' => $paginator,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @Security("is_granted('create_user')")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$user->setImageFilename($user->getEmploye()->getImageFilename());
            //$user->setAvatar($user->getEmploye()->getImageFilename());
            $user->setEnabled(true);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/customer/{id}", name="user_new_customer", methods={"GET","POST"})
     * @Security("is_granted('create_user')")
     */
    public function newUserCustomer(Customer $customer, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setCustomer($customer);
            if ($customer->isVisible()) {
                $user->setEnabled(true);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/employee/{id}", name="user_new_employee", methods={"GET","POST"})
     * @Security("is_granted('create_user')")
     */
    public function newUserEmployee(Employee $employee, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setEmployee($employee);
            if ($employee->isVisible()) {
                $user->setEnabled(true);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/customeruser/{id}", name="user_new_customer_user", methods={"GET","POST"})
     * @Security("is_granted('create_user')")
     */
    public function newUserCustomerUser(CustomerUser $customerUser, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserCustomerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setCustomerUser($customerUser);
            if ($customerUser->isVisible()) {
                $user->setEnabled(true);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('customer_user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @Security("is_granted('view_user')")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @Security("is_granted('create_user')")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$user->setImageFilename($user->getEmploye()->getImageFilename());
            //  $user->setAvatar($user->getEmploye()->getImageFilename());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @Security("is_granted('delete_user')")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/enable", name="user_enable", methods={"GET"})
     * @Security("is_granted('delete_user')")
     */
    public function enableuser(Request $request, User $user): Response
    {
        if ($user->isEnabled()) {
            $user->setEnabled(false);
            $this->getDoctrine()->getManager()->flush();
        } else {
            $user->setEnabled(true);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
