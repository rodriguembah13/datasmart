<?php

namespace App\Controller;

use App\Entity\ImplObjectif;
use App\Entity\Objectif;
use App\Form\ImplObjectifType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/implementation/objectif")
 */
class ImplementationObjectifController extends AbstractController
{
    /**
     * @Route("/", name="implementation_objectif")
     */
    public function index()
    {
        return $this->render('implementation_objectif/index.html.twig', [
            'controller_name' => 'ImplementationObjectifController',
        ]);
    }

    /**
     * @Route("/{id}/new", name="implementation_objectif_new", methods={"GET","POST"})
     */
    public function newObjectif(Request $request, ImplObjectif $implementation): Response
    {
        $form = $this->createForm(ImplObjectifType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($implementation);
            $entityManager->flush();
            $url = $this->generateUrl('implementation_objectif_new', ['id' => $implementation->getId()]);

            return $this->redirect($url);
        }
        if (null === $implementation->getOffre()) {
            $state = 'new';
        } else {
            $state = 'edit';
        }

        return $this->render('implementation/implementation_objectif.html.twig', [
            'implementation' => $implementation,
            'form' => $form->createView(),
            'state' => $state,
        ]);
    }

    /**
     * @Route("/post/response", name="response_post", methods={"GET"})
     */
    public function postresponse(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $objectif = $request->query->get('objectif');
        $quantite = $request->query->get('quantite');
        $valeur = $request->query->get('valeur');
        $delai = $request->query->get('delai');
        $frequence = $request->query->get('frequence');
        //$id = $stepStrategyRepository->find($request->query->getInt('id_step'));
        /* if (null == $id) {
             return new JsonResponse('nok', 404);
         }*/
        $postStep = new Objectif();
       // $strategyStep = $stepStrategyRepository->find($id);
        /*  if (null == $strategyStep->getResponse()) {
              $response = new Reponse();
              $response->setStepStrategy($strategyStep);
              $entityManager->persist($response);
          }*/
        // $postStep->set($valeur);
        $postStep->setQuantite($quantite);
        $postStep->set($objectif);
        $postStep->setValue($valeur);

        $entityManager->persist($postStep);
        $entityManager->flush();
        //$url = $this->generateUrl('response_new', ['id' => $request->query->get('id_step')]);

        return new JsonResponse('ok', 200);
    }

    /**
     * @Route("/{id}/edit", name="implementation_objectif_edit", methods={"GET","POST"})
     */
    public function EditObjectif(Request $request, ImplObjectif $implementation): Response
    {
        $form = $this->createForm(ImplObjectifType::class, $implementation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($implementation);
            $entityManager->flush();

            return $this->redirectToRoute('implementation_index');
        }

        return $this->render('implementation/implementation_objectif.html.twig', [
            'implementation' => $implementation,
            'form' => $form->createView(),
        ]);
    }
}
