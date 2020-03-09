<?php

namespace App\Controller;

use App\Entity\ImplObjectif;
use App\Entity\Objectif;
use App\Form\ImplObjectifType;
use App\Repository\ImplObjectifRepository;
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
     * @Route("/{id}/view", name="implementation_objectif")
     */
    public function index(ImplObjectif $implementation)
    {
        return $this->render('implementation_objectif/index.html.twig', [
            'implementation' => $implementation,
        ]);
    }

    /**
     * @Route("/{id}/new", name="implementation_objectif_new", methods={"GET","POST"},options={"expose"=true})
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
            'implObjectif' => $implementation,
            'form' => $form->createView(),
            'state' => $state,
        ]);
    }

    /**
     * @Route("/post/objectif", name="implementation_objectif_post", methods={"GET"})
     */
    public function postresponse(Request $request,ImplObjectifRepository $implObjectifRepository): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $objectif = $request->query->get('objectif');
        $quantite = $request->query->get('quantite');
        $valeur = $request->query->get('valeur');
        $delai = $request->query->get('delai');
        $frequence = $request->query->get('frequence');
        $implObjectif = $implObjectifRepository->find($request->query->getInt('id_step'));

        $postStep = new Objectif();
        $postStep->setQuantite($quantite);
        $postStep->setLibelle($objectif);
        $postStep->setValue($valeur);
        $postStep->setImplObjectif($implObjectif);

        $entityManager->persist($postStep);
        $entityManager->flush();
        //$url = $this->generateUrl('response_new', ['id' => $request->query->get('id_step')]);

        return new JsonResponse('ok', 200);
    }

    /**
     * @Route("/delete/{id}", name="implementation_objectif_delete", methods={"DELETE"},options={"expose"=true})
     */
    public function deleteResponseStep(Request $request, Objectif $objectif): JsonResponse
    {
        $id_strat=$objectif->getImplObjectif()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($objectif);
        $entityManager->flush();

        return new JsonResponse($id_strat,200);
    }
}
