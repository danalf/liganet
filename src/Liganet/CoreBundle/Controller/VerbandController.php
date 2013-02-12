<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Verband;
use Liganet\CoreBundle\Form\VerbandType;

/**
 * Verband controller.
 *
 * @Route("/verband")
 */
class VerbandController extends Controller {

    /**
     * Lists all Verband entities.
     *
     * @Route("/", name="verband")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Verband')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Verband entity.
     *
     * @Route("/{id}/show", name="verband_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verband')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verband entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new Verband entity.
     *
     * @Route("/new", name="verband_new")
     * @Template()
     */
    public function newAction() {
        if (!$this->isGrantedEdit()) {
            $this->get('session')->getFlashBag()->add('error', 'Neuen Verband anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('verband'));
        }
        $entity = new Verband();
        $form = $this->createForm(new VerbandType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Verband entity.
     *
     * @Route("/create", name="verband_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Verband:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Verband();
        $form = $this->createForm(new VerbandType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('verband_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Verband entity.
     *
     * @Route("/{id}/edit", name="verband_edit")
     * @Template()
     */
    public function editAction($id) {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diesen Verband zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('verband_show', array('id' => $id)));
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verband')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verband entity.');
        }

        $editForm = $this->createForm(new VerbandType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Verband entity.
     *
     * @Route("/{id}/update", name="verband_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Verband:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verband')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verband entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VerbandType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('verband_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Verband entity.
     *
     * @Route("/{id}/delete", name="verband_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Verband')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Verband entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('verband'));
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
    private function isGrantedEdit($spieler = NULL) {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return TRUE;
        }
        return FALSE;
    }

}
