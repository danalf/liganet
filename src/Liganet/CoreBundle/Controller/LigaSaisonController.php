<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\LigaSaison;
use Liganet\CoreBundle\Form\LigaSaisonType;

/**
 * LigaSaison controller.
 *
 * @Route("/ligasaison")
 */
class LigaSaisonController extends Controller {

    /**
     * Lists all LigaSaison entities.
     *
     * @Route("/", name="ligasaison")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:LigaSaison')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a LigaSaison entity.
     *
     * @Route("/{id}/show", name="ligasaison_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielberichtsbogen", name="ligasaison_pdf_spielberichtsbogen")
     */
    public function pdfSpielberichtsbogenAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }
        /**
         * @var \Liganet\CoreBundle\Services\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('liganet_core.pdf.spielberichtsbogen');
        $pdf->setLigaSaison($entity);
        $pdf->create();
        $pdf->ouput();

       

        return array(
            'entity' => $entity,
        );
    }
    
    /**
     * Erstellt einen Spielberichtsbogen
     *
     * @Route("/{id}/pdf/spielermeldebogen", name="ligasaison_pdf_spielermeldebogen")
     */
    public function pdfSpielermeldebogenAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }
        /**
         * @var \Liganet\CoreBundle\Services\pdfSpielberichtsbogenService Description
         */
        $pdf = $this->get('liganet_core.pdf.spielermeldebogen');
        $pdf->setLigaSaison($entity);
        $pdf->create();
        $pdf->ouput();

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Finds and displays a LigaSaison entity.
     *
     * @Route("/{id}/losung", name="ligasaison_losung")
     * @Template()
     */
    public function losungAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);
        /**
         * @var \Liganet\CoreBundle\Services\LosenService
         */
        $losung = $this->get('liganet_core.losung');

        if ($losung->setLigaSaison($entity)) {
            $losung->losen();
            /**
             * @var \Liganet\CoreBundle\Services\xmlErgebnisseService
             */
            $xml = $this->get('liganet_core.xmlErgebnisse');
            $xml->setLigaSaison($entity);
            $xml->createXmlErgebnisse();
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Diese Ligasaison losne ist nicht erlaubt.');
        };

$deleteForm = $this->createDeleteForm($id);
        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new LigaSaison entity.
     *
     * @Route("/new/liga/{liga_id}", name="ligasaison_new")
     * @Template()
     */
    public function newAction($liga_id = 0) {
        if (!$this->isGrantedEdit()) {
            $this->get('session')->getFlashBag()->add('error', 'Neue Ligasaison anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('ligasaison'));
        }
        $entity = new LigaSaison();

        if ($liga_id > 0) {
            $em = $this->getDoctrine()->getManager();
            $liga = $em->getRepository('LiganetCoreBundle:Liga')->find($liga_id);
            $entity->setLigasaison($liga);
        }

        $form = $this->createForm(new LigaSaisonType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new LigaSaison entity.
     *
     * @Route("/create", name="ligasaison_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:LigaSaison:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new LigaSaison();
        $form = $this->createForm(new LigaSaisonType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ligasaison_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LigaSaison entity.
     *
     * @Route("/{id}/edit", name="ligasaison_edit")
     * @Template()
     */
    public function editAction($id) {
        if (!$this->isGrantedEdit()) {
            $this->get('session')->getFlashBag()->add('error', 'Diesen Ligasaison zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('ligasaison_show', array('id' => $id)));
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }

        $editForm = $this->createForm(new LigaSaisonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing LigaSaison entity.
     *
     * @Route("/{id}/update", name="ligasaison_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:LigaSaison:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LigaSaisonType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ligasaison_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a LigaSaison entity.
     *
     * @Route("/{id}/delete", name="ligasaison_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LigaSaison entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ligasaison'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Legt fest, ob der User die Modusrunden verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit() {
        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{liga_id}/showList", name="ligasaison_showlist")
     * @Template()
     */
    public function showListAction($liga_id) {
        $em = $this->getDoctrine()->getManager();
        $liga = $em->getRepository('LiganetCoreBundle:Liga')->find($liga_id);
        $entities = $liga->getLigaSaison();

        return array(
            'entities' => $entities,
            'liga' => $liga,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }
    
    /**
     * Zeigt die Ergebnisse an
     *
     * @Route("/extern/{id}/showErgebnisse", name="ligasaison_showergebnisse")
     * @Template()
     */
    public function showErgebnisseAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('LiganetCoreBundle:LigaSaison')->find($id);
        $spielarten=$em->getRepository('LiganetCoreBundle:SpielArt')->findByModusOrdered($entity->getLiga()->getModus());
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LigaSaison entity.');
        }

        return array(
            'entity' => $entity,
            'spielarten' => $spielarten,
        );
    }

}
