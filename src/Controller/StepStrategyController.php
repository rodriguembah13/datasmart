<?php

namespace App\Controller;

use App\Entity\CustomerUser;
use App\Entity\MembersStep;
use App\Entity\StepStrategy;
use App\Entity\StrategyDigital;
use App\Form\MembersStepType;
use App\Form\StepStrategyType;
use App\Repository\MembersStepRepository;
use App\Repository\StepStrategyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/step/strategy")
 * @Security("is_granted('view_step')")
 */
class StepStrategyController extends AbstractController
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

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
    public function indexByStrategy(StrategyDigital $strategyDigital, StepStrategyRepository $stepStrategyRepository, MembersStepRepository $membersStepRepository): Response
    {
        // $stepsCustomer = $stepStrategyRepository->findBy(['strategy' => $strategyDigital]);
        if ($this->security->isGranted('ROLE_CUSTOMER')) {
            return $this->render('step_strategy/index.html.twig', [
                'step_strategies' => $stepStrategyRepository->findBy(['strategy' => $strategyDigital]),
            ]);
        } elseif ($this->security->isGranted('ROLE_USER')) {
            $members = $membersStepRepository->findByCustomer($strategyDigital, $this->getUser()->getCustomerUser());
            $existing = [];
            foreach ($members as $step) {
                $existing[] = $step->getStepStrategy();
            }

            return $this->render('step_strategy/index.html.twig', [
                'step_strategies' => $existing,
            ]);
        }
    }

    /**
     * @Route("/{id}/menber", name="step_strategy_member", methods={"GET","POST"},options={"expose"=true})
     * @Security("is_granted('create_step')")
     */
    public function assignMembers(Request $request, StepStrategy $stepStrategy): Response
    {
        $membersStep = new MembersStep();
        /* $form = $this->createForm(MembersStepType::class, $membersStep);
         $form->handleRequest($request);*/
        $form = $this->createFormBuilder($membersStep)
            ->add('customerUser', EntityType::class, [
                'class' => CustomerUser::class,
                'choices' => $stepStrategy->getStrategy()->getCreateBy()->getCustomerUsers(),
                'attr' => ['class' => 'selectpicker', 'data-size' => 5, 'data-live-seach' => true],
            ])->getForm();
        $form->handleRequest($request);
        //dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $membersStep->setStepStrategy($stepStrategy);
            $entityManager->persist($membersStep);
            $entityManager->flush();
            $url = $this->generateUrl('step_strategy_member', ['id' => $stepStrategy->getId()]);

            return $this->redirect($url);
        }

        return $this->render('step_strategy/assign.html.twig', [
            'step_strategy' => $stepStrategy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="step_strategy_new", methods={"GET","POST"})
     * @Security("is_granted('create_step')")
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
     * @Security("is_granted('edit_step')")
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
     * @Security("is_granted('delete_step')")
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
    /**
     * @Route("/delete/{id}/member", name="member_delete", methods={"DELETE"},options={"expose"=true})
     */
    public function deleteResponseStep(Request $request, MembersStep $membersStep): JsonResponse
    {
        $id_strat = $membersStep->getStepStrategy();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($membersStep);
        $entityManager->flush();

        return new JsonResponse($id_strat, 200);
    }
}
