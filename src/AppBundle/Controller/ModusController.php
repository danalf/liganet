<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Modus;
use AppBundle\Form\ModusType;

/**
 * Modus controller.
 *
 * @Route("/modus")
 */
class ModusController extends Controller
{
    /**
     * Lists all Modus entities.
     *
     * @Route("/", name="modus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $moduses = $em->getRepository('AppBundle:Modus')->findAll();

        return $this->render('modus/index.html.twig', array(
            'moduses' => $moduses,
        ));
    }

    /**
     * Creates a new Modus entity.
     *
     * @Route("/new", name="modus_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $modus = new Modus();
        $form = $this->createForm('AppBundle\Form\ModusType', $modus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modus);
            $em->flush();

            return $this->redirectToRoute('modus_show', array('id' => $modus->getId()));
        }

        return $this->render('modus/new.html.twig', array(
            'modus' => $modus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Modus entity.
     *
     * @Route("/{id}", name="modus_show")
     * @Method("GET")
     */
    public function showAction(Modus $modus)
    {
        $deleteForm = $this->createDeleteForm($modus);

        return $this->render('modus/show.html.twig', array(
            'modus' => $modus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Modus entity.
     *
     * @Route("/{id}/edit", name="modus_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Modus $modus)
    {
        $deleteForm = $this->createDeleteForm($modus);
        $editForm = $this->createForm('AppBundle\Form\ModusType', $modus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modus);
            $em->flush();

            return $this->redirectToRoute('modus_show', array('id' => $modus->getId()));
        }

        return $this->render('modus/edit.html.twig', array(
            'modus' => $modus,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Modus entity.
     *
     * @Route("/{id}", name="modus_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Modus $modus)
    {
        $form = $this->createDeleteForm($modus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modus);
            $em->flush();
        }

        return $this->redirectToRoute('modus_index');
    }

    /**
     * Creates a form to delete a Modus entity.
     *
     * @param Modus $modus The Modus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Modus $modus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modus_delete', array('id' => $modus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
