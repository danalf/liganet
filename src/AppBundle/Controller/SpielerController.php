<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Spieler;
use AppBundle\Entity\Verein;
use AppBundle\Form\SpielerType;

/**
 * Spieler controller.
 *
 * @Route("/spieler")
 */
class SpielerController extends Controller
{
    /**
     * Lists all Spieler entities.
     *
     * @Route("/", name="spieler_index")
     * @Method("GET")
     * @Security("has_role('ROLE_REGION_MANAGEMENT')")
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();

        $spielers = $em->getRepository('AppBundle:Spieler')->findAll();

        return $this->render('spieler/index.html.twig', array(
            'spielers' => $spielers,
        ));
    }

    /**
     * Creates a new Spieler entity.
     *
     * @Route("/new/{verein_id}", name="spieler_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("verein", options={"mapping": {"verein_id": "id"}})
     */
    public function newAction(Request $request, Verein $verein)
    {
        $this->denyAccessUnlessGranted('edit', $verein);
        
        $spieler = new Spieler();
        $spieler->setVerein($verein);
        $form = $this->createForm('AppBundle\Form\SpielerType', $spieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieler);
            $em->flush();

            return $this->redirectToRoute('spieler_show', array('id' => $spieler->getId()));
        }

        return $this->render('spieler/new.html.twig', array(
            'spieler' => $spieler,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Spieler entity.
     *
     * @Route("/{id}", name="spieler_show")
     * @Method("GET")
     */
    public function showAction(Spieler $spieler)
    {        
        $this->denyAccessUnlessGranted('view', $spieler);
        
        $deleteForm = $this->createDeleteForm($spieler);

        return $this->render('spieler/show.html.twig', array(
            'spieler' => $spieler,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Spieler entity.
     *
     * @Route("/{id}/edit", name="spieler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Spieler $spieler)
    {
        $this->denyAccessUnlessGranted('edit', $spieler);
        
        $deleteForm = $this->createDeleteForm($spieler);
        $editForm = $this->createForm('AppBundle\Form\SpielerType', $spieler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieler);
            $em->flush();

            return $this->redirectToRoute('spieler_edit', array('id' => $spieler->getId()));
        }

        return $this->render('spieler/edit.html.twig', array(
            'spieler' => $spieler,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Spieler entity.
     *
     * @Route("/{id}", name="spieler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Spieler $spieler)
    {
        $this->denyAccessUnlessGranted('edit', $spieler);
        
        $form = $this->createDeleteForm($spieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spieler);
            $em->flush();
        }

        return $this->redirectToRoute('spieler_index');
    }

    /**
     * Creates a form to delete a Spieler entity.
     *
     * @param Spieler $spieler The Spieler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Spieler $spieler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spieler_delete', array('id' => $spieler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
