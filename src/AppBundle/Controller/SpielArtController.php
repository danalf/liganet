<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\SpielArt;
use AppBundle\Form\SpielArtType;

/**
 * SpielArt controller.
 *
 * @Route("/spielart")
 */
class SpielArtController extends Controller
{
    /**
     * Lists all SpielArt entities.
     *
     * @Route("/", name="spielart_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spielArts = $em->getRepository('AppBundle:SpielArt')->findAll();

        return $this->render('spielart/index.html.twig', array(
            'spielArts' => $spielArts,
        ));
    }

    /**
     * Creates a new SpielArt entity.
     *
     * @Route("/new", name="spielart_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $spielArt = new SpielArt();
        $form = $this->createForm('AppBundle\Form\SpielArtType', $spielArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielArt);
            $em->flush();

            return $this->redirectToRoute('spielart_show', array('id' => $spielart->getId()));
        }

        return $this->render('spielart/new.html.twig', array(
            'spielArt' => $spielArt,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpielArt entity.
     *
     * @Route("/{id}", name="spielart_show")
     * @Method("GET")
     */
    public function showAction(SpielArt $spielArt)
    {
        $deleteForm = $this->createDeleteForm($spielArt);

        return $this->render('spielart/show.html.twig', array(
            'spielArt' => $spielArt,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpielArt entity.
     *
     * @Route("/{id}/edit", name="spielart_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, SpielArt $spielArt)
    {
        $deleteForm = $this->createDeleteForm($spielArt);
        $editForm = $this->createForm('AppBundle\Form\SpielArtType', $spielArt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spielArt);
            $em->flush();

            return $this->redirectToRoute('spielart_show', array('id' => $spielArt->getId()));
        }

        return $this->render('spielart/edit.html.twig', array(
            'spielArt' => $spielArt,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SpielArt entity.
     *
     * @Route("/{id}", name="spielart_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, SpielArt $spielArt)
    {
        $form = $this->createDeleteForm($spielArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spielArt);
            $em->flush();
        }

        return $this->redirectToRoute('spielart_index');
    }

    /**
     * Creates a form to delete a SpielArt entity.
     *
     * @param SpielArt $spielArt The SpielArt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpielArt $spielArt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spielart_delete', array('id' => $spielArt->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
