<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\LigaSaison;
use AppBundle\Entity\Liga;
use AppBundle\Entity\Saison;
use AppBundle\Entity\Region;
use AppBundle\Form\LigaSaisonType;

/**
 * LigaSaison controller.
 *
 * @Route("/ligasaison")
 */
class LigaSaisonController extends Controller
{

    /**
     * Lists all LigaSaison entities.
     *
     * @Route("/", name="ligasaison_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ligaSaisons = $em->getRepository('AppBundle:LigaSaison')->findAll();

        return $this->render('ligasaison/index.html.twig', array(
                    'ligaSaisons' => $ligaSaisons,
        ));
    }

    /**
     * Creates a new LigaSaison entity.
     *
     * @Route("/new/{liga_id}", name="ligasaison_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("liga", options={"mapping": {"liga_id": "id"}})
     */
    public function newAction(Request $request, Liga $liga)
    {
        $this->denyAccessUnlessGranted('edit', $liga);

        $ligaSaison = new LigaSaison();
        $ligaSaison->setLiga($liga);
        $form = $this->createForm('AppBundle\Form\LigaSaisonType', $ligaSaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ligaSaison);
            $em->flush();

            return $this->redirectToRoute('ligasaison_show', array('id' => $ligaSaison->getId()));
        }

        return $this->render('ligasaison/new.html.twig', array(
                    'ligaSaison' => $ligaSaison,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LigaSaison entity.
     *
     * @Route("/{id}", name="ligasaison_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ligaSaison = $em->getRepository('AppBundle:LigaSaison')->find($id);

        $deleteForm = $this->createDeleteForm($ligaSaison);

        return $this->render('ligasaison/show.html.twig', array(
                    'ligaSaison' => $ligaSaison,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LigaSaison entity.
     *
     * @Route("/{id}/edit", name="ligasaison_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);

        $deleteForm = $this->createDeleteForm($ligaSaison);
        $editForm = $this->createForm('AppBundle\Form\LigaSaisonType', $ligaSaison);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ligaSaison);
            $em->flush();

            return $this->redirectToRoute('ligasaison_show', array('id' => $ligaSaison->getId()));
        }

        return $this->render('ligasaison/edit.html.twig', array(
                    'ligaSaison' => $ligaSaison,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LigaSaison entity.
     *
     * @Route("/{id}", name="ligasaison_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);

        $form = $this->createDeleteForm($ligaSaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ligaSaison);
            $em->flush();
        }

        return $this->redirectToRoute('ligasaison_index');
    }

    /**
     * Creates a form to delete a LigaSaison entity.
     *
     * @param LigaSaison $ligaSaison The LigaSaison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LigaSaison $ligaSaison)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('ligasaison_delete', array('id' => $ligaSaison->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Schreibt das xml-File zur Veroeffentlichung
     *
     * @Route("/{id}/writexml", name="ligasaison_writexml")
     */
    public function writeXmlAction(LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);

        /**
         * @var \AppBundle\Util\xmlErgebnisseService
         */
        $xml = $this->get('app.util.xmlErgebnisse');
        $xml->setLigaSaison($ligaSaison);
        $xml->createXmlErgebnisse();
        $this->get('session')->getFlashBag()->add('success', 'XML für die Ligasaison erstellt');

        return $this->redirectToRoute('ligasaison_show', array('id' => $ligaSaison->getId()));
    }

    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielberichtsbogen", name="ligasaison_pdf_spielberichtsbogen")
     */
    public function pdfSpielberichtsbogenAction(LigaSaison $ligaSaison)
    {
        /**
         * @var \AppBundle\Util\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('app.util.pdf.spielberichtsbogen');
        $pdf->setLigaSaison($ligaSaison);
        $pdf->create();
        $pdf->ouput();

        return array('entity' => $ligaSaison);
    }

    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielermeldebogen", name="ligasaison_pdf_spielermeldebogen")
     */
    public function pdfSpielermeldebogenAction(LigaSaison $ligaSaison)
    {

        /**
         * @var \AppBundle\Util\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('app.util.pdf.spielermeldebogen');
        $pdf->setLigaSaison($ligaSaison);
        $pdf->create();
        $pdf->ouput();

        return array('entity' => $ligaSaison);
    }

    /**
     * Finds and displays a LigaSaison entity.
     *
     * @Route("/{id}/losung", name="ligasaison_losung")
     */
    public function losungAction(LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);

        /**
         * @var \Liganet\CoreBundle\Services\LosenService
         */
        $losung = $this->get('app.util.losung');

        if ($losung->setLigaSaison($ligaSaison)) {
            $losung->losen();
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Diese Ligasaison zu losen ist nicht erlaubt.');
        }

        $deleteForm = $this->createDeleteForm($ligaSaison);
        return $this->render('ligasaison/losung.html.twig', array(
                    'entity' => $ligaSaison,
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Finds and displays a LigaSaison entity.
     *
     * @Route("/{id}/losungplatz", name="ligasaison_losungplatz")
     */
    public function losungPlatzAction(LigaSaison $ligaSaison)
    {
        $this->denyAccessUnlessGranted('edit', $ligaSaison);

        /**
         * @var \Liganet\CoreBundle\Services\LosenService
         */
        $losung = $this->get('liganet_core.platzlosung');

        if ($losung->setLigaSaison($ligaSaison)) {
            $losung->losen();
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Diese Ligasaison zu losen ist nicht erlaubt.');
        }

        $deleteForm = $this->createDeleteForm($ligaSaison);
        return $this->render('ligasaison/losung.html.twig', array(
                    'entity' => $ligaSaison,
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * get xml information about leagues in a ligasaison
     *
     * @Route("/leagues/saison/{saison}/region/{region_kuerzel}/{_format}",
     *          name="ligasaison_get_leagues",
     *          defaults={"_format"="xml"},
     *          requirements = { "_format" = "xml" })
     * @Method({"GET", "POST"})
     */
    public function getLeaguesAction($saison, $region_kuerzel, $_format)
    {
        $em = $this->getDoctrine()->getManager();
        $ligaSaisons = $em->getRepository('AppBundle:LigaSaison')->findBySaisonAndRegion($saison, $region_kuerzel);
        if (!$ligaSaisons) {
            throw $this->createNotFoundException('Diese Ligasaison exisistiert nicht');
        }
        return $this->render('ligasaison/leagues.' . $_format . '.twig', array(
                    'ligaSaisons' => $ligaSaisons
        ));
    }

}
