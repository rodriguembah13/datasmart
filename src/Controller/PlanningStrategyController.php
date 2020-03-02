<?php

namespace App\Controller;

use App\Entity\PlanningStrategy;
use App\Entity\StepStrategy;
use App\Form\PlanningStrategyType;
use App\Repository\PlanningStrategyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning/strategy")
 */
class PlanningStrategyController extends AbstractController
{
    /**
     * @Route("/", name="planning_strategy_index", methods={"GET"})
     */
    public function index(PlanningStrategyRepository $planningStrategyRepository): Response
    {
        return $this->render('planning_strategy/index.html.twig', [
            'planning_strategies' => $planningStrategyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="planning_strategy_new", methods={"GET","POST"})
     */
    public function new(StepStrategy $stepStrategy, Request $request): Response
    {
        if (null == $stepStrategy->getPlanning()) {
            $planningStrategy = new PlanningStrategy();
            $form = $this->createForm(PlanningStrategyType::class, $planningStrategy);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $planningStrategy->setStepStrategy($stepStrategy);
                $entityManager->persist($planningStrategy);
                $entityManager->flush();
                $url = $this->generateUrl('step_strategy_index2', ['id' => $stepStrategy->getStrategy()->getId()]);

                return $this->redirect($url);
            }

            return $this->render('planning_strategy/new.html.twig', [
                'planning_strategy' => $planningStrategy,
                'form' => $form->createView(),
            ]);
        } else {
            $form = $this->createForm(PlanningStrategyType::class, $stepStrategy->getPlanning());
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $url = $this->generateUrl('step_strategy_index2', ['id' => $stepStrategy->getStrategy()->getId()]);
                return $this->redirect($url);
            }

            return $this->render('planning_strategy/edit.html.twig', [
                'planning_strategy' => $stepStrategy->getPlanning(),
                'form' => $form->createView(),
            ]);
        }

    }

    /**
     * @Route("/{id}", name="planning_strategy_show", methods={"GET"})
     */
    public function show(PlanningStrategy $planningStrategy): Response
    {
        return $this->render('planning_strategy/show.html.twig', [
            'planning_strategy' => $planningStrategy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="planning_strategy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PlanningStrategy $planningStrategy): Response
    {
        $form = $this->createForm(PlanningStrategyType::class, $planningStrategy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_strategy_index');
        }

        return $this->render('planning_strategy/edit.html.twig', [
            'planning_strategy' => $planningStrategy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_strategy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PlanningStrategy $planningStrategy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planningStrategy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planningStrategy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planning_strategy_index');
    }
}
