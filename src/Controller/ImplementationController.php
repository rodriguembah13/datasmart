<?php

namespace App\Controller;

use App\Entity\Implementation;
use App\Entity\ImplObjectif;
use App\Entity\StepStrategy;
use App\Form\ImplementationType;
use App\Form\ImplObjectifType;
use App\Repository\ImplementationRepository;
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
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        } elseif ('Définition_des_objectifs_de_base_à_atteindre' === $stepStrategy->getImplementation()->getReference()) {
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        } else {
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $stepStrategy->getImplementation()->getImplObjectif()->getId()]);
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}/planning/new", name="implementation_new_planning", methods={"GET","POST"})
     */
    public function newPlanning(ImplObjectif $implementation, Request $request): Response
    {
        // $implObjectif = $implementation->getImplObjectif();
        $form = $this->createForm(ImplObjectifType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($implementation);
            $entityManager->flush();

            return $this->redirectToRoute('implementation_index');
        }

        return $this->render('implementation/implementation_planning.html.twig', [
            'implementation' => $implementation,
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
}
