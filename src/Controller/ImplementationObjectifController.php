<?php

namespace App\Controller;

use App\Entity\ImplObjectif;
use App\Form\ImplObjectifType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function newObjectif(Request $request,ImplObjectif $implementation): Response
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

        return $this->render('implementation/implementation_objectif.html.twig', [
            'implementation' => $implementation,
           // 'form' => $form->createView(),
        ]);
    }
}
