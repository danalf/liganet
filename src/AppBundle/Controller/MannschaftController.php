<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Mannschaft;
use Liganet\CoreBundle\Form\MannschaftType;

/**
 * Mannschaft controller.
 *
 * @Route("/mannschaft")
 */
class MannschaftController extends Controller {

    /**
     * Lists all Mannschaft entities.
     *
     * @Route("/", name="mannschaft")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Mannschaft')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Mannschaft entity.
     *
     * @Route("/{id}/show", name="mannschaft_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit(NULL, $entity)
        );
    }

    /**
     * Displays a form to create a new Mannschaft entity by the verein-id
     *
     * @Route("/new/verein/{id}", name="mannschaft_new")
     * @Template()
     */
    public function newAction($id) {

        $em = $this->getDoctrine()->getManager();
        $verein = $em->getRepository('LiganetCoreBundle:Verein')->find($id);
        $entity = new Mannschaft();
        $entity->setVerein($verein);

        if (!$this->isGrantedEdit($verein)) {
            $this->get('session')->getFlashBag()->add('error', 'Neue Mannschaft anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('mannschaft'));
        }
        //$form   = $this->createForm(new MannschaftType(array(), array('id' => $entity->getId())), $entity);
        $form = $this->createForm(new MannschaftType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Mannschaft entity.
     *
     * @Route("/create", name="mannschaft_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Mannschaft:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Mannschaft();
        $form = $this->createForm(new MannschaftType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{id}/edit", name="mannschaft_edit")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }

        if (!$this->isGrantedEdit(null, $entity)) {
            $this->get('session')->getFlashBag()->add('error', 'Diese Mannschaft zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $id)));
        }

        $editForm = $this->createForm(new MannschaftType(array(), array('id' => $entity->getId())), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mannschaft entity.
     *
     * @Route("/{id}/update", name="mannschaft_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Mannschaft:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MannschaftType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Die Änderungen wurden gespeichert');

            return $this->redirect($this->generateUrl('mannschaft_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mannschaft entity.
     *
     * @Route("/{id}/delete", name="mannschaft_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mannschaft entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mannschaft'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Legt fest, ob der User (den) Spieler verändern darf oder nicht
     * @param type $spieler
     * @return boolean
     */
    private function isGrantedEdit(\Liganet\CoreBundle\Entity\Verein $verein = NULL, Mannschaft $mannschaft = NULL) {
//        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
//            return TRUE;
//        }
        if (isset($verein)) {
            foreach ($verein->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
            foreach ($verein->getRegion()->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
        };
        if (isset($mannschaft)) {
            $captain=$mannschaft->getCaptain();
            if(isset($captain)){
                if ($mannschaft->getCaptain()->getId() == $this->getUser()->getSpieler())
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
        }
        return FALSE;
    }

    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{id}/showList", name="mannschaft_showlist")
     * @Template()
     */
    public function showListAction($id) {
        $em = $this->getDoctrine()->getManager();
        $verein = $em->getRepository('LiganetCoreBundle:Verein')->find($id);

        return array(
            'verein' => $verein,
            'isGrantedEdit' => $this->isGrantedEdit($verein)
        );
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielplan", name="mannschaft_pdf_spielplan")
     */
    public function pdfSpielplanAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }
        /**
         * @var \Liganet\CoreBundle\Services\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('liganet_core.pdf.spielplan');
        $pdf->setMannschaft($entity);
        $pdf->create();
        $pdf->ouput();

        return array(
            'entity' => $entity,
        );
    }

}
