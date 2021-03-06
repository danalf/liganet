<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\MannschaftSpieler;
use AppBundle\Entity\Mannschaft;
use AppBundle\Form\MannschaftSpielerType;

/**
 * MannschaftSpieler controller.
 *
 * @Route("/mannschaftspieler")
 */
class MannschaftSpielerController extends Controller
{

    /**
     * Creates a new MannschaftSpieler entity.
     *
     * @Route("/new/{mannschaft_id}", name="mannschaftspieler_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("mannschaft", options={"mapping": {"mannschaft_id": "id"}})
     */
    public function newAction(Request $request, Mannschaft $mannschaft)
    {
        $this->denyAccessUnlessGranted('edit', $mannschaft);
        
        $mannschaftSpieler = new MannschaftSpieler();
        $mannschaftSpieler->setMannschaft($mannschaft);
        $form = $this->createForm('AppBundle\Form\MannschaftSpielerType', $mannschaftSpieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mannschaftSpieler);
            $em->flush();
            
            return $this->redirectToRoute('mannschaft_show', array('id' => $mannschaftSpieler->getMannschaft()->getId()));
        }

        return $this->render('mannschaftspieler/new.html.twig', array(
            'mannschaftSpieler' => $mannschaftSpieler,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MannschaftSpieler entity.
     *
     * @Route("/{id}/edit", name="mannschaftspieler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MannschaftSpieler $mannschaftSpieler)
    {
        $this->denyAccessUnlessGranted('edit', $mannschaftSpieler);
        
        $deleteForm = $this->createDeleteForm($mannschaftSpieler);
        $editForm = $this->createForm('AppBundle\Form\MannschaftSpielerType', $mannschaftSpieler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mannschaftSpieler);
            $em->flush();

            return $this->redirectToRoute('mannschaft_show', array('id' => $mannschaftSpieler->getMannschaft()->getId()));
        }

        return $this->render('mannschaftspieler/edit.html.twig', array(
            'mannschaftSpieler' => $mannschaftSpieler,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MannschaftSpieler entity.
     *
     * @Route("/{id}", name="mannschaftspieler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MannschaftSpieler $mannschaftSpieler)
    {
        $this->denyAccessUnlessGranted('edit', $mannschaftSpieler->getMannschaft());
        
        $form = $this->createDeleteForm($mannschaftSpieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mannschaftSpieler);
            $em->flush();
        }

        return $this->redirectToRoute('mannschaftspieler_index');
    }

    /**
     * Creates a form to delete a MannschaftSpieler entity.
     *
     * @param MannschaftSpieler $mannschaftSpieler The MannschaftSpieler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MannschaftSpieler $mannschaftSpieler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mannschaftspieler_delete', array('id' => $mannschaftSpieler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
