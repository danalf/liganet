<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Saison;
use AppBundle\Form\SaisonType;

/**
 * Saison controller.
 *
 * @Route("/saison")
 */
class SaisonController extends Controller
{
    /**
     * Lists all Saison entities.
     *
     * @Route("/", name="saison_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $saisons = $em->getRepository('AppBundle:Saison')->findAll();

        return $this->render('saison/index.html.twig', array(
            'saisons' => $saisons,
        ));
    }

    /**
     * Creates a new Saison entity.
     *
     * @Route("/new", name="saison_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $saison = new Saison();
        $form = $this->createForm('AppBundle\Form\SaisonType', $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($saison);
            $em->flush();

            return $this->redirectToRoute('saison_show', array('id' => $saison->getId()));
        }

        return $this->render('saison/new.html.twig', array(
            'saison' => $saison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Saison entity.
     *
     * @Route("/{id}", name="saison_show")
     * @Method("GET")
     */
    public function showAction(Saison $saison)
    {
        $deleteForm = $this->createDeleteForm($saison);

        return $this->render('saison/show.html.twig', array(
            'saison' => $saison,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Saison entity.
     *
     * @Route("/{id}/edit", name="saison_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Saison $saison)
    {
        $deleteForm = $this->createDeleteForm($saison);
        $editForm = $this->createForm('AppBundle\Form\SaisonType', $saison);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($saison);
            $em->flush();

            return $this->redirectToRoute('saison_edit', array('id' => $saison->getId()));
        }

        return $this->render('saison/edit.html.twig', array(
            'saison' => $saison,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Saison entity.
     *
     * @Route("/{id}", name="saison_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Saison $saison)
    {
        $form = $this->createDeleteForm($saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($saison);
            $em->flush();
        }

        return $this->redirectToRoute('saison_index');
    }

    /**
     * Creates a form to delete a Saison entity.
     *
     * @param Saison $saison The Saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Saison $saison)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('saison_delete', array('id' => $saison->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
