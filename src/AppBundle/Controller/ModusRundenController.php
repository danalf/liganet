<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\ModusRunden;
use AppBundle\Form\ModusRundenType;

/**
 * ModusRunden controller.
 *
 * @Route("/modusrunden")
 * @Security("has_role('ROLE_ADMIN')")
 */
class ModusRundenController extends Controller
{
    /**
     * Lists all ModusRunden entities.
     *
     * @Route("/", name="modusrunden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modusRunden = $em->getRepository('AppBundle:ModusRunden')->findAll();

        return $this->render('modusrunden/index.html.twig', array(
            'modusRunden' => $modusRunden,
        ));
    }

    /**
     * Creates a new ModusRunden entity.
     *
     * @Route("/new", name="modusrunden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $modusRunden = new ModusRunden();
        $form = $this->createForm('AppBundle\Form\ModusRundenType', $modusRunden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modusRunden);
            $em->flush();

            return $this->redirectToRoute('modusrunden_show', array('id' => $modusrunden->getId()));
        }

        return $this->render('modusrunden/new.html.twig', array(
            'modusRunden' => $modusRunden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ModusRunden entity.
     *
     * @Route("/{id}", name="modusrunden_show")
     * @Method("GET")
     */
    public function showAction(ModusRunden $modusRunden)
    {
        $deleteForm = $this->createDeleteForm($modusRunden);

        return $this->render('modusrunden/show.html.twig', array(
            'modusRunde' => $modusRunden,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ModusRunden entity.
     *
     * @Route("/{id}/edit", name="modusrunden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ModusRunden $modusRunden)
    {
        $deleteForm = $this->createDeleteForm($modusRunden);
        $editForm = $this->createForm('AppBundle\Form\ModusRundenType', $modusRunden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modusRunden);
            $em->flush();

            return $this->redirectToRoute('modusrunden_show', array('id' => $modusRunden->getId()));
        }

        return $this->render('modusrunden/edit.html.twig', array(
            'modusRunden' => $modusRunden,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ModusRunden entity.
     *
     * @Route("/{id}", name="modusrunden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ModusRunden $modusRunden)
    {
        $form = $this->createDeleteForm($modusRunden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modusRunden);
            $em->flush();
        }

        return $this->redirectToRoute('modusrunden_index');
    }

    /**
     * Creates a form to delete a ModusRunden entity.
     *
     * @param ModusRunden $modusRunden The ModusRunden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ModusRunden $modusRunden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modusrunden_delete', array('id' => $modusRunden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
