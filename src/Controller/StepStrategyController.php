<?php

namespace App\Controller;

use App\Entity\StepStrategy;
use App\Entity\StrategyDigital;
use App\Form\StepStrategyType;
use App\Repository\StepStrategyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/step/strategy")
 */
class StepStrategyController extends AbstractController
{
    /**
     * @Route("/", name="step_strategy_index", methods={"GET"})
     */
    public function index(StepStrategyRepository $stepStrategyRepository): Response
    {
        return $this->render('step_strategy/index.html.twig', [
            'step_strategies' => $stepStrategyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/list", name="step_strategy_index2", methods={"GET"})
     */
    public function indexByStrategy(StrategyDigital $strategyDigital, StepStrategyRepository $stepStrategyRepository): Response
    {
        return $this->render('step_strategy/index.html.twig', [
            'step_strategies' => $stepStrategyRepository->findBy(['strategy' => $strategyDigital]),
        ]);
    }

    /**
     * @Route("/new", name="step_strategy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stepStrategy = new StepStrategy();
        $form = $this->createForm(StepStrategyType::class, $stepStrategy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stepStrategy);
            $entityManager->flush();

            return $this->redirectToRoute('step_strategy_index');
        }

        return $this->render('step_strategy/new.html.twig', [
            'step_strategy' => $stepStrategy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="step_strategy_show", methods={"GET"})
     */
    public function show(StepStrategy $stepStrategy): Response
    {
        return $this->render('step_strategy/show.html.twig', [
            'step_strategy' => $stepStrategy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="step_strategy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StepStrategy $stepStrategy): Response
    {
        $form = $this->createForm(StepStrategyType::class, $stepStrategy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('step_strategy_index');
        }

        return $this->render('step_strategy/edit.html.twig', [
            'step_strategy' => $stepStrategy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="step_strategy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StepStrategy $stepStrategy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stepStrategy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stepStrategy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('step_strategy_index');
    }
}
