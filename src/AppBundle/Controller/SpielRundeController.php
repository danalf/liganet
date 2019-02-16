<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\SpielRunde;
use AppBundle\Entity\Spieltag;
use AppBundle\Form\SpielRundeType;

/**
 * SpielRunde controller.
 *
 * @Route("/spielrunde")
 */
class SpielRundeController extends Controller
{
    /**
     * Creates a new SpielRunde entity.
     *
     * @Route("/new/{spieltag_id}", name="spielrunde_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("spieltag", options={"mapping": {"spieltag_id": "id"}})
     */
    public function newAction(Request $request, Spieltag $spieltag)
    {
        $this->denyAccessUnlessGranted('edit', $spieltag);
        
        $spielRunde = new SpielRunde();
        $spielRunde->setSpieltag($spieltag);
        $form = $this->createForm('AppBundle\Form\SpielRundeType', $spielRunde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielRunde);
            $em->flush();

            return $this->redirectToRoute('spieltag_show', array('id' => $spielRunde->getSpieltag()->getId()));
        }

        return $this->render('spielrunde/new.html.twig', array(
            'spielRunde' => $spielRunde,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpielRunde entity.
     *
     * @Route("/{id}", name="spielrunde_show")
     * @Method("GET")
     */
    public function showAction(SpielRunde $spielRunde)
    {
        $deleteForm = $this->createDeleteForm($spielRunde);

        return $this->render('spielrunde/show.html.twig', array(
            'spielRunde' => $spielRunde,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpielRunde entity.
     *
     * @Route("/{id}/edit", name="spielrunde_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpielRunde $spielRunde)
    {
        $this->denyAccessUnlessGranted('edit', $spielRunde);
        
        $deleteForm = $this->createDeleteForm($spielRunde);
        $editForm = $this->createForm('AppBundle\Form\SpielRundeType', $spielRunde);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielRunde);
            $em->flush();

            return $this->redirectToRoute('spielrunde_show', array('id' => $spielRunde->getId()));
        }

        return $this->render('spielrunde/edit.html.twig', array(
            'spielRunde' => $spielRunde,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SpielRunde entity.
     *
     * @Route("/{id}", name="spielrunde_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SpielRunde $spielRunde)
    {
        $this->denyAccessUnlessGranted('edit', $spielRunde);
        
        $form = $this->createDeleteForm($spielRunde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spielRunde);
            $em->flush();
        }

        return $this->redirectToRoute('spielrunde_index');
    }

    /**
     * Creates a form to delete a SpielRunde entity.
     *
     * @param SpielRunde $spielRunde The SpielRunde entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpielRunde $spielRunde)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spielrunde_delete', array('id' => $spielRunde->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
