<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\MannschaftSpieler;
use Liganet\CoreBundle\Form\MannschaftSpielerType;

/**
 * MannschaftSpieler controller.
 *
 * @Route("/mannschaftspieler")
 */
class MannschaftSpielerController extends Controller {

    /**
     * Lists all MannschaftSpieler entities.
     *
     * @Route("/", name="mannschaftspieler")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a MannschaftSpieler entity.
     *
     * @Route("/{id}/show", name="mannschaftspieler_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit($entity->getMannschaft())
        );
    }

    /**
     * Displays a form to create a new MannschaftSpieler entity.
     *
     * @Route("/new/mannschaft/{id}", name="mannschaftspieler_new")
     * @Template()
     */
    public function newAction($id) {
        $em = $this->getDoctrine()->getManager();
        $mannschaft = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$this->isGrantedEdit($mannschaft)) {
            $this->get('session')->getFlashBag()->add('error', 'Neuen Mannschaftspieler anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('mannschaftspieler'));
        }
        $entity = new MannschaftSpieler();
        $entity->setMannschaft($mannschaft);

        $form = $this->createForm(new MannschaftSpielerType(array(), array('id' => $mannschaft->getId())), $entity);

        //$form   = $this->createForm(new MannschaftSpielerType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new MannschaftSpieler entity.
     *
     * @Route("/create", name="mannschaftspieler_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:MannschaftSpieler:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new MannschaftSpieler();
        $form = $this->createForm(new MannschaftSpielerType(), $entity);
        $form->bind($request);
        //Mannschaft hinzufügen
        $mannschaft_id = $request->get('mannschaft_id');
        $em = $this->getDoctrine()->getManager();
        $mannschaft = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($mannschaft_id);
        $entity->setMannschaft($mannschaft);
        $this->setUpdateInformation($entity);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $mannschaft_id)));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MannschaftSpieler entity.
     *
     * @Route("/{id}/edit", name="mannschaftspieler_edit")
     * @Template()
     */
    public function editAction($id) {


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$this->isGrantedEdit($entity->getMannschaft())) {
            $this->get('session')->getFlashBag()->add('error', 'Diesen Mannschaftspieler zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('mannschaftspieler_show', array('id' => $id)));
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $editForm = $this->createForm(new MannschaftSpielerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MannschaftSpieler entity.
     *
     * @Route("/{id}/update", name="mannschaftspieler_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:MannschaftSpieler:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MannschaftSpielerType(), $entity);
        $editForm->bind($request);
        $this->setUpdateInformation($entity);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $entity->getMannschaft()->getId())));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MannschaftSpieler entity.
     *
     * @Route("/{id}/delete", name="mannschaftspieler_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        if (!$this->get('security.context')->isGranted('ROLE_REGION_MANAGEMENT')) {
            $this->get('session')->getFlashBag()->add('error', 'Löschen ist für dich nicht erlaubt');
            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $entity->getMannschaft()->getId())));
        }
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Der Mannschaftsspieler wurde gelöscht');
        }

        return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $entity->getMannschaft()->getId())));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Legt fest, ob der User (den) Spieler verändern darf oder nicht
     * @param type $mannschaft
     * @return boolean
     */
    private function isGrantedEdit(\Liganet\CoreBundle\Entity\Mannschaft $mannschaft = NULL) {
//        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
//            return TRUE;
//        }
        if (!isset($mannschaft))
            return FALSE;
        $captain=$mannschaft->getCaptain();
        if(isset($captain)){
            if ($captain->getId() == $this->getUser()->getSpieler())
            return TRUE;
        }
        foreach ($mannschaft->getVerein()->getLeiter() as $leiter) {
            if ($this->getUser()->getSpieler() == $leiter->getId())
                return TRUE;
        }
        foreach ($mannschaft->getLigasaison()->getStaffelleiter() as $leiter) {
            if ($this->getUser()->getSpieler() == $leiter->getId())
                return TRUE;
        }
        foreach ($mannschaft->getLigasaison()->getLiga()->getRegion()->getLeiter() as $leiter) {
            if ($this->getUser()->getSpieler() == $leiter->getId())
                return TRUE;
        }

        return FALSE;
    }


    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{id}/showList", name="mannschaftspieler_showlist")
     * @Template()
     */
    public function showListAction($id) {
        $em = $this->getDoctrine()->getManager();
        $mannschaft = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        return array(
            'mannschaft' => $mannschaft,
            'isGrantedEdit' => $this->isGrantedEdit($mannschaft)
        );
    }

    /**
     * Setzt die bestätigt und Bearbeitet-Variable des Spielers
     * @param \Liganet\CoreBundle\Entity\Spieler $entity
     * @return \Liganet\CoreBundle\Entity\Spieler
     */
    private function setUpdateInformation(MannschaftSpieler $entity) {
        //$em = $this->getDoctrine()->getManager();
        //$bearbeiter_id = $em->getRepository('LiganetCoreBundle:Spieler')->find($this->getUser()->getSpieler());
        //$bearbeiter = $em->getRepository('LiganetCoreBundle:Spieler')->find($bearbeiter_id);
        //$entity->setVeraendertvon($bearbeiter);
        //$entity->setVeraendertam();
        //
        //Bei einer Rolle kleiner als Staffelleiter wird Bestaetig auf false gesetzt
        if (!$this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            $entity->setBestaetigt(false);
        } else {
            $entity->setBestaetigt(true);
        }
        return $entity;
    }

}
