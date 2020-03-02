<?php

namespace App\Controller;

use App\Entity\CustomerUser;
use App\Form\CustomerUserType;
use App\Repository\CustomerUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users/customer")
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
     */
    public function new(Request $request): Response
    {
        $customerUser = new CustomerUser();
        $form = $this->createForm(CustomerUserType::class, $customerUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (null == $this->getUser()->getCustomer()) {
                $this->addFlash('error', 'il faut etre customer');

                //return $this->redirectToRoute('customer_user_new');
            } else {
                $customerUser->setCreatedBy($this->getUser()->getCustomer());
            }

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
     * @Route("/{id}", name="customer_user_show", methods={"GET"})
     */
    public function show(CustomerUser $customerUser): Response
    {
        return $this->render('customer_user/show.html.twig', [
            'customer_user' => $customerUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_user_edit", methods={"GET","POST"})
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
}
