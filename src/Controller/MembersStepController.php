<?php

namespace App\Controller;

use App\Entity\MembersStep;
use App\Form\MembersStepType;
use App\Repository\MembersStepRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/members/step")
 * @Security("is_granted('view_project')")
 */
class MembersStepController extends AbstractController
{
    /**
     * @Route("/", name="members_step_index", methods={"GET"})
     */
    public function index(MembersStepRepository $membersStepRepository): Response
    {
        return $this->render('members_step/index.html.twig', [
            'members_steps' => $membersStepRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="members_step_new", methods={"GET","POST"})
     * @Security("is_granted('create_project')")
     */
    public function new(Request $request): Response
    {
        $membersStep = new MembersStep();
        $form = $this->createForm(MembersStepType::class, $membersStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membersStep);
            $entityManager->flush();
            $this->addFlash('success', 'Operation effectuée avec success');

            return $this->redirectToRoute('members_step_index');
        }

        return $this->render('members_step/new.html.twig', [
            'members_step' => $membersStep,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="members_step_show", methods={"GET"})
     * @Security("is_granted('create_project')")
     */
    public function show(MembersStep $membersStep): Response
    {
        return $this->render('members_step/show.html.twig', [
            'members_step' => $membersStep,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="members_step_edit", methods={"GET","POST"})
     * @Security("is_granted('create_project')")
     */
    public function edit(Request $request, MembersStep $membersStep): Response
    {
        $form = $this->createForm(MembersStepType::class, $membersStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('members_step_index');
        }

        return $this->render('members_step/edit.html.twig', [
            'members_step' => $membersStep,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="members_step_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MembersStep $membersStep): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membersStep->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membersStep);
            $entityManager->flush();
            $this->addFlash('success', 'Operation effectuée avec success');
        }

        return $this->redirectToRoute('members_step_index');
    }
}
