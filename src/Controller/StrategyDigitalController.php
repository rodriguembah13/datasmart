<?php

namespace App\Controller;

use App\Entity\ImplAvatar;
use App\Entity\ImplDefault;
use App\Entity\Implementation;
use App\Entity\ImplObjectif;
use App\Entity\ImplPlanning;
use App\Entity\Response as Reponse;
use App\Entity\StepStrategy;
use App\Entity\StrategyDigital;
use App\Form\StrategyDigitalEditType;
use App\Form\StrategyDigitalType;
use App\Repository\MembersStepRepository;
use App\Repository\StepRepository;
use App\Repository\StepStrategyRepository;
use App\Repository\StrategyDigitalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @var AuthorizationCheckerInterface
     */
    private $security;

    /**
     * StrategyDigitalController constructor.
     */
    public function __construct(StepRepository $stepRepository, AuthorizationCheckerInterface $security)
    {
        $this->stepRepository = $stepRepository;
        $this->security = $security;
    }

    /**
     * @Route("/", name="strategy_digital_index", methods={"GET"})
     */
    public function index(StrategyDigitalRepository $strategyDigitalRepository): Response
    {
        if ($this->security->isGranted('ROLE_CUSTOMER')) {
            return $this->render('strategy_digital/index.html.twig', [
                'strategy_digitals' => $strategyDigitalRepository->findBy(['createBy' => $this->getUser()->getCustomer()]),
                'user' => 'customer',
            ]);
        } elseif ($this->security->isGranted('ROLE_USER')) {
            return $this->render('strategy_digital/index.html.twig', [
                'strategy_digitals' => $strategyDigitalRepository->findBy(['createBy' => $this->getUser()->getCustomerUser()->getCreatedBy()]),
                'user' => 'customerUser',
            ]);
        }
    }

    /**
     * @Route("/admin", name="strategy_digital_index_admin", methods={"GET"})
     */
    public function index_admin(StrategyDigitalRepository $strategyDigitalRepository): Response
    {
        if ($this->security->isGranted(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])) {
            return $this->render('strategy_digital/index.html.twig', [
                'strategy_digitals' => $strategyDigitalRepository->findAll(),
            ]);
        } elseif ($this->security->isGranted(['ROLE_COACH'])) {
            $existings = [];
            foreach ($this->getUser()->getEmployee()->getCustomersCoach() as $customersCoach) {
                $strategysBycustomer = $strategyDigitalRepository->findBy(['createBy' => $customersCoach]);
                foreach ($strategysBycustomer as $strategy) {
                    $existings[] = $strategy;
                }
            }

            return $this->render('strategy_digital/index.html.twig', [
                'strategy_digitals' => $existings,
            ]);
        }
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
            /*$response = new Reponse();
            $response->setCreatedAt(new \DateTime('now'));
            $response->setName(' ');*/
            $stepStrategy->setStep($step);
            $stepStrategy->setStrategy($strategyDigital);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stepStrategy);
            //$response->setStepStrategy($stepStrategy);
            $this->createImplementation($stepStrategy);
            /// $entityManager->persist($response);
        }
        $entityManager->flush();
    }

    public function createImplementation(StepStrategy $stepStrategy)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $impl = new Implementation();
        $impl->setStepStrategy($stepStrategy);
        $impl->setReference($stepStrategy->getStep()->getValue());
        $entityManager->persist($impl);
        if ('Planification_détaillée_de_la_mise_en_œuvre_de_la_stratégie_de_marketing_digitale' === $impl->getReference()) {
            $planning = new ImplPlanning();
            $planning->setImplementation($impl);
            $planning->setStatus(false);
            $entityManager->persist($planning);
        } elseif ('Définition_des_objectifs_de_base_à_atteindre' === $impl->getReference()) {
            $defObjec = new ImplObjectif();
            $defObjec->setImplementation($impl);
            $entityManager->persist($defObjec);
        } elseif ('Identification_de_la_cible_principale_ou_du_client_idéal' === $impl->getReference()) {
            $avatar = new ImplAvatar();
            $avatar->setImplementation($impl);
            $entityManager->persist($avatar);
        } else {
            $defaul = new ImplDefault();
            $defaul->setImplementation($impl);
            $entityManager->persist($defaul);
        }
    }

    /**
     * @Route("/{id}", name="strategy_digital_show", methods={"GET"})
     */
    public function show(StrategyDigital $strategyDigital, StepStrategyRepository $stepStrategyRepository, MembersStepRepository $membersStepRepository): Response
    {
        if ($this->security->isGranted('ROLE_CUSTOMER')) {
            return $this->render('strategy_digital/show.html.twig', [
                'step_strategies' => $stepStrategyRepository->findBy(['strategy' => $strategyDigital]),
                'strategy_digital' => $strategyDigital,
            ]);
        } elseif ($this->security->isGranted('ROLE_USER')) {
            $members = $membersStepRepository->findByCustomer($strategyDigital, $this->getUser()->getCustomerUser());
            $existing = [];
            foreach ($members as $step) {
                $existing[] = $step->getStepStrategy();
            }

            return $this->render('strategy_digital/show.html.twig', [
                'step_strategies' => $existing,
                'strategy_digital' => $strategyDigital,
            ]);
        }
        /* return $this->render('strategy_digital/show.html.twig', [
             'strategy_digital' => $strategyDigital,
             'step_strategies' => $strategyDigital->getStepStrategies(),
         ]);*/
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
