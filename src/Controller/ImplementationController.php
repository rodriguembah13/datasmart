<?php

namespace App\Controller;

use App\Entity\Implementation;
use App\Form\ImplementationType;
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
     * @Route("/{id}", name="implementation_show", methods={"GET"})
     */
    public function show(Implementation $implementation): Response
    {
        return $this->render('implementation/show.html.twig', [
            'implementation' => $implementation,
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
