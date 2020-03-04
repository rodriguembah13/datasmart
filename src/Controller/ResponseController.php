<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Response as Reponse;
use App\Entity\StepStrategy;
use App\Form\CommentType;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/response")
 */
class ResponseController extends AbstractController
{
    /**
     * @Route("/", name="response_index", methods={"GET"})
     */
    public function index(ResponseRepository $responseRepository): Response
    {
        return $this->render('response/index.html.twig', [
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="response_new", methods={"GET","POST"})
     */
    public function new(StepStrategy $stepStrategy, Request $request): Response
    {
        if (null !== $stepStrategy->getResponse()) {
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);
            return $this->redirect($url);
        }
        $response = new Reponse();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $response->setStepStrategy($stepStrategy);
            $entityManager->persist($response);
            $entityManager->flush();
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);

            return $this->redirect($url);
        }

        return $this->render('response/new.html.twig', [
            'response' => $response,
            'stepStrategy' => $stepStrategy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_show", methods={"GET"})
     */
    public function show(Reponse $response): Response
    {
        return $this->render('response/show.html.twig', [
            'response' => $response,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="response_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StepStrategy $stepStrategy): Response
    {
        $form = $this->createForm(ResponseType::class, $stepStrategy->getResponse());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);

            return $this->redirect($url);
        }
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $comment->setEmployee($this->getUser()->getEmployee());
            $comment->setResponse($stepStrategy->getResponse());
            $comment->setCreatedAt(new \DateTime('now'));
            $entityManager->flush();
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);

            return $this->redirect($url);
        }
        return $this->render('response/edit.html.twig', [
            'response' => $stepStrategy->getResponse(),
            'form' => $form->createView(),
            'formComment' => $formComment->createView(),
            'stepStrategy' => $stepStrategy,
        ]);
    }

    /**
     * @Route("/{id}", name="response_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reponse $response): Response
    {
        if ($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($response);
            $entityManager->flush();
        }

        return $this->redirectToRoute('response_index');
    }
}
