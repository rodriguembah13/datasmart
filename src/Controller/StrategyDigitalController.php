<?php

namespace App\Controller;

use App\Entity\StepStrategy;
use App\Entity\StrategyDigital;
use App\Form\StrategyDigitalEditType;
use App\Form\StrategyDigitalType;
use App\Repository\StepRepository;
use App\Repository\StrategyDigitalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/strategy/digital")
 * @Security("is_granted('view_project')")
 */
class StrategyDigitalController extends AbstractController
{/**
 * @var StepRepository
 */
    private $stepRepository;

    /**
     * StrategyDigitalController constructor.
     */
    public function __construct(StepRepository $stepRepository)
    {
        $this->stepRepository = $stepRepository;
    }

    /**
     * @Route("/", name="strategy_digital_index", methods={"GET"})
     */
    public function index(StrategyDigitalRepository $strategyDigitalRepository): Response
    {
        return $this->render('strategy_digital/index.html.twig', [
            'strategy_digitals' => $strategyDigitalRepository->findBy(['createBy' => $this->getUser()->getCustomer()]),
        ]);
    }

    /**
     * @Route("/{id}/planning", name="strategy_digital_planning", methods={"GET"})
     */
    public function planning(StrategyDigital $strategyDigital, StrategyDigitalRepository $strategyDigitalRepository): Response
    {
        return $this->render('strategy_digital/planning.html.twig', [
            'strategy_digital' => $strategyDigital,
        ]);
    }

    private function nbreweekbetween(\DateTime $dateBegin, \DateTime $dateEnd)
    {

    }

    /**
     * @Route("/new", name="strategy_digital_new", methods={"GET","POST"})
     * @Security("is_granted('create_project')")
     */
    public function new(Request $request): Response
    {
        $strategyDigital = new StrategyDigital();
        $form = $this->createForm(StrategyDigitalType::class, $strategyDigital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $strategyDigital->setStatut(false);
            if (null == $this->getUser()->getCustomer()) {
                $this->addFlash('error', 'Desole,Il faut etre un customer');

                return $this->redirectToRoute('homepage');
            } else {
                $strategyDigital->setCreateBy($this->getUser()->getCustomer());
            }

            $entityManager->persist($strategyDigital);
            $this->createStep($strategyDigital);
            $entityManager->flush();
            $url = $this->generateUrl('step_strategy_index2', ['id' => $strategyDigital->getId()]);

            return $this->redirect($url);
        }

        return $this->render('strategy_digital/new.html.twig', [
            'strategy_digital' => $strategyDigital,
            'form' => $form->createView(),
        ]);
    }

    public function createStep(StrategyDigital $strategyDigital)
    {
        $steps = $this->stepRepository->findAll();
        foreach ($steps as $step) {
            $stepStrategy = new StepStrategy();
            $stepStrategy->setStep($step);
            $stepStrategy->setStrategy($strategyDigital);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stepStrategy);
        }
        $entityManager->flush();
    }

    /**
     * @Route("/{id}", name="strategy_digital_show", methods={"GET"})
     */
    public function show(StrategyDigital $strategyDigital): Response
    {
        return $this->render('strategy_digital/show.html.twig', [
            'strategy_digital' => $strategyDigital,
            'step_strategies' => $strategyDigital->getStepStrategies(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="strategy_digital_edit", methods={"GET","POST"})
     * @Security("is_granted('edit_project')")
     */
    public function edit(Request $request, StrategyDigital $strategyDigital): Response
    {
        $form = $this->createForm(StrategyDigitalEditType::class, $strategyDigital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('strategy_digital_index');
        }

        return $this->render('strategy_digital/edit.html.twig', [
            'strategy_digital' => $strategyDigital,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="strategy_digital_delete", methods={"DELETE"})
     * @Security("is_granted('delete_project')")
     */
    public function delete(Request $request, StrategyDigital $strategyDigital): Response
    {
        if ($this->isCsrfTokenValid('delete'.$strategyDigital->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($strategyDigital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('strategy_digital_index');
    }
}
