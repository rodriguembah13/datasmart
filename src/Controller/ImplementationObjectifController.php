<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\ImplObjectif;
use App\Entity\Objectif;
use App\Form\CommentType;
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
    public function index(ImplObjectif $implementation, Request $request, \Swift_Mailer $mailer)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $customer = $implementation->getImplementation()->getStepStrategy()->getStrategy()->getCreateBy();
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setEmployee($this->getUser()->getEmployee());
            $comment->setStepStrategy($implementation->getImplementation()->getStepStrategy());
            $comment->setSendTo($customer);
            $comment->setStatus(false);
            $entityManager->persist($comment);
            $entityManager->flush();
            // $this->sendMail($customer->getName(), $customer->getCompte()->getEmail(), $this->getUser()->getEmail(), $swift_Mailer);
            $message = (new \Swift_Message('Smart Message'))
                ->setFrom($this->getUser()->getEmail())
                ->setTo($customer->getCompte()->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/messageOne.html.twig',
                        ['name' => $customer->getName(),
                            'message' => $comment->getLibelle(),
                            'step' => $implementation->getImplementation()->getStepStrategy()->getStep()->getName(),
                            'strategy' => $implementation->getImplementation()->getStepStrategy()->getStrategy()->getName(),
                            ]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            $url = $this->generateUrl('implementation_objectif', ['id' => $implementation->getId()]);

            return $this->redirect($url);
        }

        return $this->render('implementation_objectif/index.html.twig', [
            'implementation' => $implementation,
            'form' => $form->createView(),
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
    public function postresponse(Request $request, ImplObjectifRepository $implObjectifRepository): JsonResponse
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
        $id_strat = $objectif->getImplObjectif()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($objectif);
        $entityManager->flush();

        return new JsonResponse($id_strat, 200);
    }

    /**
     * @Route("/validate/{id}/coach", name="implementation_objectif_validate_coach", methods={"GET"},options={"expose"=true})
     */
    public function validatecoach(ImplObjectif $implObjectif)
    {
        $implementation = $implObjectif->getImplementation();
        $entityManager = $this->getDoctrine()->getManager();
        if ($implementation->getValideCoach()) {
            $implementation->setValideCoach(false);
            $implementation->setUserCoach($this->getUser());
        } else {
            $implementation->setValideCoach(true);
            $implementation->setUserCoach($this->getUser());
            $implementation->setDateValidateCoach(new \DateTime('now'));
        }
        $entityManager->persist($implementation);
        $entityManager->flush();
        $url = $this->generateUrl('implementation_objectif', ['id' => $implObjectif->getId()]);

        return $this->redirect($url);
    }

    public function sendMail($name, $sendMail, $receiveMail, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Smart Message'))
            ->setFrom($sendMail)
            ->setTo($receiveMail)
            ->setBody(
                $this->renderView(
                    'emails/messageOne.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )
        ;
        $mailer->send($message);
        $this->addFlash('notice', 'Email sent');
    }
}
