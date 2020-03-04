<?php

namespace App\Controller;

use App\Entity\CustomerUser;
use App\Form\CustomerUserType;
use App\Form\UserCustomerType;
use App\Repository\CustomerUserRepository;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users/customer")
 * @Security("is_granted('view_customeruser')")
 */
class CustomerUserController extends AbstractController
{
    /**
     * @Route("/", name="customer_user_index", methods={"GET"})
     */
    public function index(CustomerUserRepository $customerUserRepository): Response
    {
        return $this->render('customer_user/index.html.twig', [
            'customer_users' => $customerUserRepository->findBy(['createdBy' => $this->getUser()->getCustomer()]),
        ]);
    }

    /**
     * @Route("/new", name="customer_user_new", methods={"GET","POST"})
     * @Security("is_granted('create_customeruser')")
     */
    public function new(Request $request): Response
    {
        $customerUser = new CustomerUser();
        $form = $this->createForm(CustomerUserType::class, $customerUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (null == $this->getUser()->getCustomer()) {
                $this->addFlash('error', 'Desole,Il faut etre un customer');

                return $this->redirectToRoute('homepage');
            } else {
                $customerUser->setCreatedBy($this->getUser()->getCustomer());
            }
            $customerUser->setVisible(true);
            $customerUser->setRegisteredAt(new \DateTime('now'));
            $entityManager->persist($customerUser);
            $entityManager->flush();
            $url = $this->generateUrl('user_new_customer_user', ['id' => $customerUser->getId()]);

            return $this->redirect($url);
        }

        return $this->render('customer_user/new.html.twig', [
            'customer_user' => $customerUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_user_show", methods={"GET","POST"})
     */
    public function show(Request $request, CustomerUser $customerUser): Response
    {
        $form = $this->createForm(CustomerUserType::class, $customerUser);
        $formPassword = $this->createForm(ProfileFormType::class, $customerUser->getCompte());
        $formUser = $this->createForm(UserCustomerType::class, $customerUser->getCompte());
        $form->handleRequest($request);
        $formPassword->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('customer_user_show', ['id' => $customerUser->getId()]);

            return $this->redirect($url);
        }

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('customer_user_show', ['id' => $customerUser->getId()]);

            return $this->redirect($url);
        }
        return $this->render('customer_user/show.html.twig', [
            'customer_user' => $customerUser,
            'user' => $customerUser->getCompte(),
            'strategy_digitals' => $customerUser->getStrategyDigitals(),
            'form' => $form->createView(),
            'formPassworld' => $formPassword->createView(),
            'formUser' => $formUser->createView(),
            'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'],['Mes Strategies Digital', '#strategie']],
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_user_edit", methods={"GET","POST"})
     * @Security("is_granted('edit_customeruser')")
     */
    public function edit(Request $request, CustomerUser $customerUser): Response
    {
        $form = $this->createForm(CustomerUserType::class, $customerUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_user_index');
        }

        return $this->render('customer_user/edit.html.twig', [
            'customer_user' => $customerUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_user_delete", methods={"DELETE"})
     * @Security("is_granted('delete_customeruser')")
     */
    public function delete(Request $request, CustomerUser $customerUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customerUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customerUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_user_index');
    }

    /**
     * @Route("/{id}/enable", name="customer_user_enable", methods={"GET"})
     * @Security("is_granted('edit_customeruser')")
     */
    public function enableuser(Request $request, CustomerUser $customer): Response
    {
        if ($customer->isVisible()) {
            $customer->setVisible(false);
            $customer->getCompte()->setEnabled(false);
            $this->getDoctrine()->getManager()->flush();
        } else {
            $customer->setVisible(true);
            $customer->getCompte()->setEnabled(true);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('customer_user_index');
    }
}
