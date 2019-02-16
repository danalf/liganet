<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Spieltag;
use AppBundle\Entity\LigaSaison;
use AppBundle\Form\SpieltagType;

/**
 * Spieltag controller.
 *
 * @Route("/spieltag")
 */
class SpieltagController extends Controller
{
    /**
     * Lists all Spieltag entities.
     *
     * @Route("/", name="spieltag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spieltage = $em->getRepository('AppBundle:Spieltag')->findAll();

        return $this->render('spieltag/index.html.twig', array(
            'spieltage' => $spieltage,
        ));
    }

    /**
     * Creates a new Spieltag entity.
     *
     * @Route("/new/{ligasaison_id}", name="spieltag_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("ligaSaison", options={"mapping": {"ligasaison_id": "id"}})
     */
    public function newAction(Request $request, LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);
        
        $spieltag = new Spieltag();
        $spieltag->setLigasaison($ligaSaison);
        $form = $this->createForm('AppBundle\Form\SpieltagType', $spieltag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieltag);
            $em->flush();

            return $this->redirectToRoute('spieltag_show', array('id' => $spieltag->getId()));
        }

        return $this->render('spieltag/new.html.twig', array(
            'spieltag' => $spieltag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Spieltag entity.
     *
     * @Route("/{id}", name="spieltag_show")
     * @Method("GET")
     */
    public function showAction(Spieltag $spieltag)
    {
        $deleteForm = $this->createDeleteForm($spieltag);

        return $this->render('spieltag/show.html.twig', array(
            'spieltag' => $spieltag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Spieltag entity.
     *
     * @Route("/{id}/edit", name="spieltag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Spieltag $spieltag)
    {
        $this->denyAccessUnlessGranted('edit', $spieltag);
        
        $deleteForm = $this->createDeleteForm($spieltag);
        $editForm = $this->createForm('AppBundle\Form\SpieltagType', $spieltag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieltag);
            $em->flush();

            return $this->redirectToRoute('spieltag_show', array('id' => $spieltag->getId()));
        }

        return $this->render('spieltag/edit.html.twig', array(
            'spieltag' => $spieltag,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Spieltag entity.
     *
     * @Route("/{id}", name="spieltag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Spieltag $spieltag)
    {
        $this->denyAccessUnlessGranted('edit', $spieltag);
        
        $form = $this->createDeleteForm($spieltag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spieltag);
            $em->flush();
        }

        return $this->redirectToRoute('spieltag_index');
    }

    /**
     * Creates a form to delete a Spieltag entity.
     *
     * @param Spieltag $spieltag The Spieltag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Spieltag $spieltag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spieltag_delete', array('id' => $spieltag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/excel/ergebnisse", name="spieltag_excel_ergebnisse")
     */
    public function excelErgebnisseAction(Spieltag $spieltag) {

        /**
         * @var \AppBundle\Util\pdfSpielberichtsbogenService Description
         */
        $excel = $this->get('app.util.excel.spieltag');
        $excel->setSpieltag($spieltag);
        $excel->createExcel();

        return array('entity' => $spieltag);
    }

}
