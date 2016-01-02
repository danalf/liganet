<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Spieltag;
use Liganet\CoreBundle\Form\SpieltagType;

/**
 * Spieltag controller.
 *
 * @Route("/spieltag")
 */
class SpieltagController extends Controller {

    /**
     * Lists all Spieltag entities.
     *
     * @Route("/", name="spieltag")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Spieltag')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Spieltag entity.
     *
     * @Route("/{id}/show", name="spieltag_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);
        $ligasaison = $entity->getLigaSaison();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spieltag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit($ligasaison, $ligasaison->getLiga())
        );
    }

    /**
     * Displays a form to create a new Spieltag entity.
     *
     * @Route("/new/ligasaison/{ligasaison_id}", name="spieltag_new")
     * @Template()
     */
    public function newAction($ligasaison_id = 0) {
        $entity = new Spieltag;
        if ($ligasaison_id > 0) {
            $em = $this->getDoctrine()->getManager();
            $ligasaison = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($ligasaison_id);
            $entity->setLigasaison($ligasaison);
            if (!$this->isGrantedEdit($ligasaison, $ligasaison->getLiga())) {
                $this->get('session')->getFlashBag()->add('error', 'Neuen Spieltag anlegen ist für dich nicht nicht erlaubt');
                return $this->redirect($this->generateUrl('spieltag'));
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Neuen Spieltag anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spieltag'));
        }






        $form = $this->createForm(new SpieltagType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Spieltag entity.
     *
     * @Route("/create", name="spieltag_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Spieltag:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Spieltag();
        $form = $this->createForm(new SpieltagType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spieltag_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Spieltag entity.
     *
     * @Route("/{id}/edit", name="spieltag_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);
        $ligasaison = $entity->getLigaSaison();
        
        if (!$this->isGrantedEdit($ligasaison, $ligasaison->getLiga())) {
            $this->get('session')->getFlashBag()->add('error', 'Diesen Spieltag zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spieltag_show', array('id' => $id)));
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spieltag entity.');
        }

        $editForm = $this->createForm(new SpieltagType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Spieltag entity.
     *
     * @Route("/{id}/update", name="spieltag_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Spieltag:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spieltag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpieltagType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spieltag_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Spieltag entity.
     *
     * @Route("/{id}/delete", name="spieltag_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Spieltag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spieltag'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Legt fest, ob der User (den) Spieltag verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit(\Liganet\CoreBundle\Entity\LigaSaison $ligasaison = null, \Liganet\CoreBundle\Entity\Liga $liga = null) {
        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            return TRUE;
        }
        if (isset($ligasaison)) {
            foreach ($ligasaison->getStaffelleiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
        }

        if (isset($liga)) {
            foreach ($liga->getRegion()->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Zeigt die Spieltage einer Ligasaison an
     *
     * @Route("/{ligasaison_id}/showList", name="spieltag_showlist")
     * @Template()
     */
    public function showListAction($ligasaison_id) {
        $em = $this->getDoctrine()->getManager();
        $ligasaison = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($ligasaison_id);

        return array(
            'ligasaison' => $ligasaison,
            'isGrantedEdit' => $this->isGrantedEdit($ligasaison, $ligasaison->getLiga())
        );
    }
    
    /**
     * Lists all Spiele from one Spieler
     *
     * @Route("/spieler/{spieler_id}", name="spieltag_spieler")
     * @Template()
     */
    public function showBySpielerAction($spieler_id) {
        $em = $this->getDoctrine()->getManager();
        $spieler = $em->getRepository('LiganetCoreBundle:Spieler')->find($spieler_id);
        $entities = $em->getRepository('LiganetCoreBundle:Spieltag')->findBySpieler($spieler);


        return array(
            'entities' => $entities,
            'isGrantedEdit' => false,
            'spielerid' => $spieler_id,
        );
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/excel/ergebnisse", name="spieltag_excel_ergebnisse")
     */
    public function excelErgebnisseAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }
        /**
         * @var \Liganet\CoreBundle\Services\pdfSpielberichtsbogenService Description
         */
        $excel = $this->get('liganet_core.excel.spieltag');
        $excel->setSpieltag($entity);
        $excel->createExcel();

        return array(
            'entity' => $entity,
        );
    }

}
