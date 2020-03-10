<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Form\UserType;
use App\Repository\EmployeeRepository;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employee")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="employee_index", methods={"GET"})
     */
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $employee->setRegisteredAt(new \DateTime('now'));
            $entityManager->persist($employee);
            $entityManager->flush();
            $url = $this->generateUrl('user_new_employee', ['id' => $employee->getId()]);
            return $this->redirect($url);
        }

        return $this->render('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_show", methods={"GET","POST"})
     */
    public function show(Request $request, Employee $employee): Response
    {$form = $this->createForm(EmployeeType::class, $employee);
        $formPassword = $this->createForm(ProfileFormType::class, $employee->getCompte());
        $formUser = $this->createForm(UserType::class, $employee->getCompte());
        $form->handleRequest($request);
        $formPassword->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('employee_show', ['id' => $employee->getId()]);

            return $this->redirect($url);
        }

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('employee_show', ['id' => $employee->getId()]);

            return $this->redirect($url);
        }
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
           // 'strategy_digitals' => $customerUser->getStrategyDigitals(),
            'form' => $form->createView(),
            'formPassworld' => $formPassword->createView(),
            'formUser' => $formUser->createView(),
            'user' => $employee->getCompte(),
            'tabs' => [['Information Personnel', '#personnelle'], ['Mon Compte', '#compte'],['Mes Strategies Digital', '#strategie']],
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Employee $employee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index');
    }
}
