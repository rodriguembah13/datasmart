<?php

namespace App\Controller;

use App\Entity\Documentaire;
use App\Form\DocumentaireType;
use App\Repository\DocumentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/documentaire")
 */
class DocumentaireController extends AbstractController
{
    /**
     * @Route("/", name="documentaire_index", methods={"GET"})
     */
    public function index(DocumentaireRepository $documentaireRepository): Response
    {
        return $this->render('documentaire/index.html.twig', [
            'documentaires' => $documentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="documentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $documentaire = new Documentaire();
        $form = $this->createForm(DocumentaireType::class, $documentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documentaire);
            $entityManager->flush();

            return $this->redirectToRoute('documentaire_index');
        }

        return $this->render('documentaire/new.html.twig', [
            'documentaire' => $documentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="documentaire_show", methods={"GET"})
     */
    public function show(Documentaire $documentaire): Response
    {
        return $this->render('documentaire/show.html.twig', [
            'documentaire' => $documentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="documentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Documentaire $documentaire): Response
    {
        $form = $this->createForm(DocumentaireType::class, $documentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('documentaire_index');
        }

        return $this->render('documentaire/edit.html.twig', [
            'documentaire' => $documentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="documentaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Documentaire $documentaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($documentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('documentaire_index');
    }
}
