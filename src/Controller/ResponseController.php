<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Response as Reponse;
use App\Entity\ResponseStep;
use App\Entity\StepStrategy;
use App\Form\CommentType;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use App\Repository\StepStrategyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/response")
 */
class ResponseController extends AbstractController
{
    /**
     * @Route("/", name="response_index", methods={"GET"},options={"expose"=true})
     */
    public function index(ResponseRepository $responseRepository): Response
    {
        return $this->render('response/index.html.twig', [
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="response_new", methods={"GET","POST"},options={"expose"=true})
     */
    public function new(StepStrategy $stepStrategy, Request $request): Response
    {
        /*if (null !== $stepStrategy->getResponse()) {
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);

            return $this->redirect($url);
        }*/
        $response = new Reponse();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);
        if ('Identification_de_la_cible_principale_ou_du_client_idéal' == $stepStrategy->getStep()->getValue()) {
            $responeStep1 = new ResponseStep();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $response->setStepStrategy($stepStrategy);
            $entityManager->persist($response);
            $entityManager->flush();
            $url = $this->generateUrl('response_edit', ['id' => $stepStrategy->getId()]);
            return $this->redirect($url);
        }

        return $this->render('response/new.html.twig', [
            'response' => $stepStrategy->getResponse(),
            'stepStrategy' => $stepStrategy,
            'form' => $form->createView(),
            'typeStep' => $stepStrategy->getStep()->getValue(),
        ]);
    }

    /**
     * @Route("/post/response", name="response_post", methods={"GET"})
     */
    public function postresponse(Request $request, ResponseRepository $responseRepository, StepStrategyRepository $stepStrategyRepository): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $objectif = $request->query->get('objectif');
        $quantite = $request->query->get('quantite');
        $valeur = $request->query->get('valeur');
        $delai = $request->query->get('delai');
        $frequence = $request->query->get('frequence');
        $id = $stepStrategyRepository->find($request->query->getInt('id_step'));
        if (null == $id) {
            return new JsonResponse('nok', 404);
        }
        $postStep = new ResponseStep();
        $postStep->setDelai($delai);
        $strategyStep = $stepStrategyRepository->find($id);
      /*  if (null == $strategyStep->getResponse()) {
            $response = new Reponse();
            $response->setStepStrategy($strategyStep);
            $entityManager->persist($response);
        }*/
        // $postStep->set($valeur);
        $postStep->setQuantite($quantite);
        $postStep->setObjectif($objectif);
        $postStep->setFrequence($frequence);
        $postStep->setTypeStep($request->query->get('typeStep'));
        //$postStep->setResponse($responseRepository->findOneBy(['stepStrategy' => $strategyStep]));
        $postStep->setResponse($strategyStep->getResponse());

        $entityManager->persist($postStep);
        $entityManager->flush();
        //$url = $this->generateUrl('response_new', ['id' => $request->query->get('id_step')]);

        return new JsonResponse('ok', 200);
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
    /**
     * @Route("/{id}", name="responseStep_delete", methods={"DELETE"},options={"expose"=true})
     */
    public function deleteResponseStep(Request $request, ResponseStep $response): JsonResponse
    {
        $id_strat=$response->getResponse()->getStepStrategy()->getId();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($response);
            $entityManager->flush();

        return new JsonResponse($id_strat,200);
    }
}
