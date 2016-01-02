<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Liga;
use AppBundle\Form\LigaType;

/**
 * Liga controller.
 *
 * @Route("/liga")
 */
class LigaController extends Controller
{
    /**
     * Lists all Liga entities.
     *
     * @Route("/", name="liga_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ligas = $em->getRepository('AppBundle:Liga')->findAll();

        return $this->render('liga/index.html.twig', array(
            'ligas' => $ligas,
        ));
    }

    /**
     * Creates a new Liga entity.
     *
     * @Route("/new", name="liga_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_LEAGUE_MANAGEMENT')")
     */
    public function newAction(Request $request)
    {
        $liga = new Liga();
        $form = $this->createForm('AppBundle\Form\LigaType', $liga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($liga);
            $em->flush();

            return $this->redirectToRoute('liga_show', array('id' => $liga->getId()));
        }

        return $this->render('liga/new.html.twig', array(
            'liga' => $liga,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Liga entity.
     *
     * @Route("/{id}", name="liga_show")
     * @Method("GET")
     */
    public function showAction(Liga $liga)
    {
        $deleteForm = $this->createDeleteForm($liga);

        return $this->render('liga/show.html.twig', array(
            'liga' => $liga,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Liga entity.
     *
     * @Route("/{id}/edit", name="liga_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_LEAGUE_MANAGEMENT')")
     */
    public function editAction(Request $request, Liga $liga)
    {
        $deleteForm = $this->createDeleteForm($liga);
        $editForm = $this->createForm('AppBundle\Form\LigaType', $liga);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($liga);
            $em->flush();

            return $this->redirectToRoute('liga_edit', array('id' => $liga->getId()));
        }

        return $this->render('liga/edit.html.twig', array(
            'liga' => $liga,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Liga entity.
     *
     * @Route("/{id}", name="liga_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_LEAGUE_MANAGEMENT')")
     */
    public function deleteAction(Request $request, Liga $liga)
    {
        $form = $this->createDeleteForm($liga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($liga);
            $em->flush();
        }

        return $this->redirectToRoute('liga_index');
    }

    /**
     * Creates a form to delete a Liga entity.
     *
     * @param Liga $liga The Liga entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Liga $liga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('liga_delete', array('id' => $liga->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
