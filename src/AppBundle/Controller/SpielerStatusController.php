<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\SpielerStatus;
use AppBundle\Form\SpielerStatusType;

/**
 * SpielerStatus controller.
 *
 * @Route("/spielerstatus")
 * @Security("has_role('ROLE_ADMIN')")
 */
class SpielerStatusController extends Controller
{
    /**
     * Lists all SpielerStatus entities.
     *
     * @Route("/", name="spielerstatus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spielerStatuses = $em->getRepository('AppBundle:SpielerStatus')->findAll();

        return $this->render('spielerstatus/index.html.twig', array(
            'spielerStatuses' => $spielerStatuses,
        ));
    }

    /**
     * Creates a new SpielerStatus entity.
     *
     * @Route("/new", name="spielerstatus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $spielerStatus = new SpielerStatus();
        $form = $this->createForm('AppBundle\Form\SpielerStatusType', $spielerStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielerStatus);
            $em->flush();

            return $this->redirectToRoute('spielerstatus_show', array('id' => $spielerstatus->getId()));
        }

        return $this->render('spielerstatus/new.html.twig', array(
            'spielerStatus' => $spielerStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpielerStatus entity.
     *
     * @Route("/{id}", name="spielerstatus_show")
     * @Method("GET")
     */
    public function showAction(SpielerStatus $spielerStatus)
    {
        $deleteForm = $this->createDeleteForm($spielerStatus);

        return $this->render('spielerstatus/show.html.twig', array(
            'spielerStatus' => $spielerStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpielerStatus entity.
     *
     * @Route("/{id}/edit", name="spielerstatus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpielerStatus $spielerStatus)
    {
        $deleteForm = $this->createDeleteForm($spielerStatus);
        $editForm = $this->createForm('AppBundle\Form\SpielerStatusType', $spielerStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielerStatus);
            $em->flush();

            return $this->redirectToRoute('spielerstatus_edit', array('id' => $spielerStatus->getId()));
        }

        return $this->render('spielerstatus/edit.html.twig', array(
            'spielerStatus' => $spielerStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SpielerStatus entity.
     *
     * @Route("/{id}", name="spielerstatus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SpielerStatus $spielerStatus)
    {
        $form = $this->createDeleteForm($spielerStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spielerStatus);
            $em->flush();
        }

        return $this->redirectToRoute('spielerstatus_index');
    }

    /**
     * Creates a form to delete a SpielerStatus entity.
     *
     * @param SpielerStatus $spielerStatus The SpielerStatus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpielerStatus $spielerStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spielerstatus_delete', array('id' => $spielerStatus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
