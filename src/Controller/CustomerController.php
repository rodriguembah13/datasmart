<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Form\UserType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customer")
 * @Security("is_granted('view_customer')")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/", name="customer_index", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository, EntityManagerInterface $manager, PaginatorInterface $paginator, Request $request): Response
    {
        $dql = 'SELECT a FROM App\Entity\Customer a';
        $query = $manager->createQuery($dql);
        $paginator = $paginator->paginate($query, $request->query->getInt('page', 1), 8);

        return $this->render('customer/index.html.twig', [
            'customers' => $paginator,
        ]);
    }

    /**
     * @Route("/new", name="customer_new", methods={"GET","POST"})
     * @Security("is_granted('create_customer')")
     */
    public function new(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $customer->setRegisteredAt(new \DateTime('now'));
            $customer->setCreatedBy($this->getUser()->getEmployee());
            $entityManager->persist($customer);
            $entityManager->flush();
            $url = $this->generateUrl('user_new_customer', ['id' => $customer->getId()]);

            return $this->redirect($url);
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     */
    public function show(Request $request, Customer $customer): Response
    {$form = $this->createForm(CustomerType::class, $customer);
        $formPassword = $this->createForm(ProfileFormType::class, $customer->getCompte());
        $formUser = $this->createForm(UserType::class, $customer->getCompte());
        $form->handleRequest($request);
        $formPassword->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('employee_show', ['id' => $customer->getId()]);

            return $this->redirect($url);
        }

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('employee_show', ['id' => $customer->getId()]);

            return $this->redirect($url);
        }
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
             'strategy_digitals' => $customer->getStrategyDigitals(),
            'form' => $form->createView(),
            'formPassworld' => $formPassword->createView(),
            'formUser' => $formUser->createView(),
            'user' => $customer->getCompte(),
            'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'],['Mes Strategies Digital', '#strategie']],
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET","POST"})
     * @Security("is_granted('edit_customer')")
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"DELETE"})
     * @Security("is_granted('delete_customer')")
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_index');
    }

    /**
     * @Route("/{id}/enable", name="customer_enable", methods={"GET"})
     * @Security("is_granted('edit_customer')")
     */
    public function enableuser(Request $request, Customer $customer): Response
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

        return $this->redirectToRoute('customer_index');
    }
}
