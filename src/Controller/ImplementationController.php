<?php

namespace App\Controller;

use App\Entity\Implementation;
use App\Entity\ImplObjectif;
use App\Entity\ImplPlanning;
use App\Entity\Planning;
use App\Entity\StepStrategy;
use App\Form\ImplementationType;
use App\Form\ImplObjectifType;
use App\Form\PlanningType;
use App\Repository\ImplementationRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/implementation")
 */
class ImplementationController extends AbstractController
{
    /**
     * @Route("/", name="implementation_index", methods={"GET"})
     */
    public function index(ImplementationRepository $implementationRepository): Response
    {
        return $this->render('implementation/index.html.twig', [
            'implementations' => $implementationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="implementation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $implementation = new Implementation();
        $form = $this->createForm(ImplementationType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($implementation);
            $entityManager->flush();

            return $this->redirectToRoute('implementation_index');
        }

        return $this->render('implementation/new.html.twig', [
            'implementation' => $implementation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="implementation_show", methods={"GET"})
     */
    public function show(Implementation $implementation): Response
    {
        return $this->render('implementation/show.html.twig', [
            'implementation' => $implementation,
        ]);
    }

    /**
     * @Route("/{id}", name="implementation_display", methods={"GET"})
     */
    public function display(StepStrategy $stepStrategy): Response
    {
        if ('Identification_de_la_cible_principale_ou_du_client_idéal' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_new_avatar', ['id' => $stepStrategy->getImplementation()->getImplAvatar()->getId()]);
        } elseif ('Planification_détaillée_de_la_mise_en_œuvre_de_la_stratégie_de_marketing_digitale' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_new_planning', ['id' => $stepStrategy->getImplementation()->getImplPlanning()->getId()]);
        } elseif ('Définition_des_objectifs_de_base_à_atteindre' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        } else {
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}/view", name="implementation_display_vew", methods={"GET"})
     */
    public function displayView(StepStrategy $stepStrategy): Response
    {
        if ('Identification_de_la_cible_principale_ou_du_client_idéal' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_new_avatar', ['id' => $stepStrategy->getImplementation()->getImplAvatar()->getId()]);
        } elseif ('Planification_détaillée_de_la_mise_en_œuvre_de_la_stratégie_de_marketing_digitale' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_view_planning', ['id' => $stepStrategy->getImplementation()->getImplPlanning()->getId()]);
        } elseif ('Définition_des_objectifs_de_base_à_atteindre' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_objectif', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        } else {
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}/planning/new", name="implementation_new_planning", methods={"GET","POST"})
     */
    public function newPlanning(ImplPlanning $implementation, Request $request, PlanningRepository $planningRepository): Response
    {
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $planning->setImplPlanning($implementation);
            if (null == $planningRepository->findOneBy(['stepStrategy' => $planning->getStepStrategy(), 'implPlanning' => $implementation])) {
                $entityManager->persist($planning);
                $entityManager->flush();
            } else {
                $existPlanning = $planningRepository->findOneBy(['stepStrategy' => $planning->getStepStrategy(), 'implPlanning' => $implementation]);
                $existPlanning->setDateBegin($planning->getDateBegin());
                $existPlanning->setDateEnd($planning->getDateEnd());
                $entityManager->persist($existPlanning);
                $entityManager->flush();
            }

            $url = $this->generateUrl('implementation_new_planning', ['id' => $implementation->getId()]);

            return $this->redirect($url);
        }
        $plannings = $planningRepository->findAll();

        return $this->render('implementation/implementation_planning.html.twig', [
            'planning' => $implementation,
            'plannings' => $plannings,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/avatar/new", name="implementation_new_avatar", methods={"GET","POST"})
     */
    public function newAvatar(ImplObjectif $implementation, Request $request): Response
    {
        $form = $this->createForm(ImplObjectifType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($implementation);
            $entityManager->flush();

            return $this->redirectToRoute('implementation_index');
        }

        return $this->render('implementation/implementation_avatar.html.twig', [
            'implementation' => $implementation,
            //'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="implementation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Implementation $implementation): Response
    {
        $form = $this->createForm(ImplementationType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('implementation_index');
        }

        return $this->render('implementation/edit.html.twig', [
            'implementation' => $implementation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/view/{id}", name="implementation_view_planning", methods={"GET"})
     */
    public function viewPlanning(ImplPlanning $implementation, EntityManagerInterface $manager, PlanningRepository $planningRepository): Response
    {
        $max_date = $manager->createQuery("SELECT MAX(p.dateEnd) from App\Entity\Planning p where p.implPlanning =:impl")
                        ->setParameter('impl', $implementation)->getSingleScalarResult();
        $min_date = $manager->createQuery("SELECT MIN(p.dateBegin) from App\Entity\Planning p where p.implPlanning =:impl")
            ->setParameter('impl', $implementation)->getSingleScalarResult();
        $dateStart = \DateTime::createFromFormat('y-m-d', $min_date);
        $dateend = \DateTime::createFromFormat('y-m-d', $max_date);

        return $this->render('implementation/viewPlanning.html.twig', [
            'planning' => $implementation,
            'max' => $max_date,
            'min' => $min_date,
            'max_' => date_create($max_date),
            'min_' => date_create($min_date),
            'week' => $this->getNumberWeekOfDays(date_create($min_date), date_create($max_date)),
            'monday' => $this->getNumberMondayOfDays(date_create($min_date), date_create($max_date)),
            'diff' => date_create($min_date)->diff(date_create($max_date))->d,
        ]);
    }

    /**
     * @Route("/{id}", name="implementation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Implementation $implementation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$implementation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($implementation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('implementation_index');
    }

    private function getNumberWeekOfDays(\DateTimeInterface $startDate, \DateTimeInterface $endDate): int
    {
        $startNumber = (int) $startDate->format('N');
        $endNumber = (int) $endDate->format('N');
        $daybetween = $endDate->diff($startDate)->d;
        $weekendDays = (int) (2 * ($daybetween + $startNumber) / 7);
        $weekendDays = $weekendDays - (7 == $startNumber ? 1 : 0) - (7 == $endNumber ? 1 : 0);

        return $weekendDays;
    }

    private function getNumberMondayOfDays(\DateTimeInterface $startDate, \DateTimeInterface $endDate): int
    {
        $startNumber = (int) $startDate->format('N');
        $endNumber = (int) $endDate->format('N');
        $daybetween = $endDate->diff($startDate)->d;
        $weekendDays = (int) (2 * ($daybetween + $startNumber) / 7);
        $weekendDays = $weekendDays - (1 == $startNumber ? 1 : 0) - (1 == $endNumber ? 1 : 0);

        return $weekendDays;
    }
}
