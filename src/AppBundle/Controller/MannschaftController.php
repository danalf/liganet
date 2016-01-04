<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Mannschaft;
use AppBundle\Form\MannschaftType;

/**
 * Mannschaft controller.
 *
 * @Route("/mannschaft")
 */
class MannschaftController extends Controller
{
    /**
     * Lists all Mannschaft entities.
     *
     * @Route("/", name="mannschaft_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mannschaften = $em->getRepository('AppBundle:Mannschaft')->findAll();

        return $this->render('mannschaft/index.html.twig', array(
            'mannschaften' => $mannschaften,
        ));
    }

    /**
     * Creates a new Mannschaft entity.
     *
     * @Route("/new", name="mannschaft_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mannschaft = new Mannschaft();
        $form = $this->createForm('AppBundle\Form\MannschaftType', $mannschaft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mannschaft);
            $em->flush();

            return $this->redirectToRoute('mannschaft_show', array('id' => $mannschaft->getId()));
        }

        return $this->render('mannschaft/new.html.twig', array(
            'mannschaft' => $mannschaft,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mannschaft entity.
     *
     * @Route("/{id}", name="mannschaft_show")
     * @Method("GET")
     */
    public function showAction(Mannschaft $mannschaft)
    {
        $deleteForm = $this->createDeleteForm($mannschaft);

        return $this->render('mannschaft/show.html.twig', array(
            'mannschaft' => $mannschaft,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{id}/edit", name="mannschaft_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mannschaft $mannschaft)
    {
        $deleteForm = $this->createDeleteForm($mannschaft);
        $editForm = $this->createForm('AppBundle\Form\MannschaftType', $mannschaft);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mannschaft);
            $em->flush();

            return $this->redirectToRoute('mannschaft_edit', array('id' => $mannschaft->getId()));
        }

        return $this->render('mannschaft/edit.html.twig', array(
            'mannschaft' => $mannschaft,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Mannschaft entity.
     *
     * @Route("/{id}", name="mannschaft_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mannschaft $mannschaft)
    {
        $form = $this->createDeleteForm($mannschaft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mannschaft);
            $em->flush();
        }

        return $this->redirectToRoute('mannschaft_index');
    }

    /**
     * Creates a form to delete a Mannschaft entity.
     *
     * @param Mannschaft $mannschaft The Mannschaft entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mannschaft $mannschaft)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mannschaft_delete', array('id' => $mannschaft->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielplan", name="mannschaft_pdf_spielplan")
     */
    public function pdfSpielplanAction(Mannschaft $mannschaft) {
        /**
         * @var \Liganet\CoreBundle\Services\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('app.util.pdf.spielplan');
        $pdf->setMannschaft($mannschaft);
        $pdf->create();
        $pdf->ouput();

        return array('entity' => $mannschaft);
    }
}
