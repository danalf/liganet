<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Verband;
use AppBundle\Form\VerbandType;

/**
 * Verband controller.
 *
 * @Route("/verband")
 */
class VerbandController extends Controller
{
    /**
     * Lists all Verband entities.
     *
     * @Route("/", name="verband_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $verbands = $em->getRepository('AppBundle:Verband')->findAll();

        return $this->render('verband/index.html.twig', array(
            'verbands' => $verbands,
        ));
    }

    /**
     * Creates a new Verband entity.
     *
     * @Route("/new", name="verband_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $verband = new Verband();
        $form = $this->createForm('AppBundle\Form\VerbandType', $verband);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($verband);
            $em->flush();

            return $this->redirectToRoute('verband_show', array('id' => $verband->getId()));
        }

        return $this->render('verband/new.html.twig', array(
            'verband' => $verband,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Verband entity.
     *
     * @Route("/{id}", name="verband_show")
     * @Method("GET")
     */
    public function showAction(Verband $verband)
    {
        $deleteForm = $this->createDeleteForm($verband);

        return $this->render('verband/show.html.twig', array(
            'verband' => $verband,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Verband entity.
     *
     * @Route("/{id}/edit", name="verband_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Verband $verband)
    {
        $deleteForm = $this->createDeleteForm($verband);
        $editForm = $this->createForm('AppBundle\Form\VerbandType', $verband);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($verband);
            $em->flush();

            return $this->redirectToRoute('verband_edit', array('id' => $verband->getId()));
        }

        return $this->render('verband/edit.html.twig', array(
            'verband' => $verband,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Verband entity.
     *
     * @Route("/{id}", name="verband_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Verband $verband)
    {
        $form = $this->createDeleteForm($verband);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($verband);
            $em->flush();
        }

        return $this->redirectToRoute('verband_index');
    }

    /**
     * Creates a form to delete a Verband entity.
     *
     * @param Verband $verband The Verband entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Verband $verband)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('verband_delete', array('id' => $verband->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
