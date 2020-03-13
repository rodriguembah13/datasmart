<?php

namespace App\Controller;

use App\Entity\CibleAvatar;
use App\Entity\Comment;
use App\Entity\Employee;
use App\Entity\ImplAvatar;
use App\Entity\Implementation;
use App\Entity\ImplPlanning;
use App\Entity\Planning;
use App\Entity\StepStrategy;
use App\Form\CibleAvatarType;
use App\Form\CommentType;
use App\Form\ImplementationType;
use App\Form\PlanningType;
use App\Repository\CibleAvatarRepository;
use App\Repository\ImplementationRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
            $url = $this->generateUrl('implementation_new_default', ['id' => $stepStrategy->getImplementation()->getId()]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}/view", name="implementation_display_vew", methods={"GET"})
     */
    public function displayView(StepStrategy $stepStrategy): Response
    {
        if ('Identification_de_la_cible_principale_ou_du_client_idéal' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_view_avatar', ['id' => $stepStrategy->getImplementation()->getImplAvatar()->getId()]);
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
        $plannings = $planningRepository->findByStrategy($implementation->getImplementation()->getStepStrategy()->getStrategy());

        return $this->render('implementation/implementation_planning.html.twig', [
            'planning' => $implementation,
            'plannings' => $plannings,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/default/new", name="implementation_new_default", methods={"GET","POST"})
     */
    public function newDefault(Implementation $implementation, Request $request): Response
    {
        // $cible = new CibleAvatar();
        //$implementation = new Implementation();
        $form = $this->createForm(ImplementationType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // $cible->setImplAvatar($implementation);
            // $entityManager->persist($cible);
            $entityManager->flush();
            $url = $this->generateUrl('implementation_new_avatar', ['id' => $implementation->getId()]);

            return $this->redirect($url);
        }

        return $this->render('implementation/new.html.twig', [
            'avatar' => $implementation,
            'form' => $form->createView(),
           // 'cibles' => $cibleAvatarRepository->findBy(['implAvatar' => $implementation]),
        ]);
    }

    /**
     * @Route("/{id}/avatar/new", name="implementation_new_avatar", methods={"GET","POST"})
     */
    public function newAvatar(ImplAvatar $implementation, Request $request, CibleAvatarRepository $cibleAvatarRepository): Response
    {
        $cible = new CibleAvatar();
        $form = $this->createForm(CibleAvatarType::class, $cible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $cible->setImplAvatar($implementation);
            $entityManager->persist($cible);
            $entityManager->flush();
            $url = $this->generateUrl('implementation_new_avatar', ['id' => $implementation->getId()]);

            return $this->redirect($url);
        }

        return $this->render('implementation/implementation_avatar.html.twig', [
            'avatar' => $implementation,
            'form' => $form->createView(),
            'cibles' => $cibleAvatarRepository->findBy(['implAvatar' => $implementation]),
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
     * @Route("/view/{id}", name="implementation_view_planning", methods={"GET","POST"})
     */
    public function viewPlanning(ImplPlanning $implementation, EntityManagerInterface $manager, Request $request, PlanningRepository $planningRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser()->getEmployee();
            if (!is_object($user) || !$user instanceof Employee) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setEmployee($user);
            $comment->setStepStrategy($implementation->getImplementation()->getStepStrategy());
            $comment->setSendTo($implementation->getImplementation()->getStepStrategy()->getStrategy()->getCreateBy());
            $comment->setStatus(false);
            $entityManager->persist($comment);
            $entityManager->flush();
            $url = $this->generateUrl('implementation_view_planning', ['id' => $implementation->getId()]);
            return $this->redirect($url);
        }
        $plannings = $planningRepository->findByStrategy($implementation->getImplementation()->getStepStrategy()->getStrategy());

        return $this->render('implementation/viewPlanning.html.twig', [
            'form' => $form->createView(),
            'planning' => $implementation,
            'plannings' => $plannings,
        ]);
    }

    /**
     * @Route("/viewAvatar/{id}", name="implementation_view_avatar", methods={"GET","POST"})
     */
    public function viewAvatar(ImplAvatar $implementation, EntityManagerInterface $manager, Request $request, PlanningRepository $planningRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setEmployee($this->getUser()->getEmployee());
            $comment->setStepStrategy($implementation->getImplementation()->getStepStrategy());
            $comment->setSendTo($implementation->getImplementation()->getStepStrategy()->getStrategy()->getCreateBy());
            $comment->setStatus(false);
            $entityManager->persist($comment);
            $entityManager->flush();
            $url = $this->generateUrl('implementation_view_avatar', ['id' => $implementation->getId()]);
            return $this->redirect($url);
        }
        return $this->render('implementation/viewAvatar.html.twig', [
            'cible' => $implementation,
            'form' => $form->createView(),
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
