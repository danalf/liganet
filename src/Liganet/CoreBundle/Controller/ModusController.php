<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Modus;
use Liganet\CoreBundle\Form\ModusType;

/**
 * Modus controller.
 *
 * @Route("/modus")
 */
class ModusController extends Controller
{
    /**
     * Lists all Modus entities.
     *
     * @Route("/", name="modus")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Modus')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Modus entity.
     *
     * @Route("/{id}/show", name="modus_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Modus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new Modus entity.
     *
     * @Route("/new", name="modus_new")
     * @Template()
     */
    public function newAction()
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neuen Modus anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('modus'));
        }
        $entity = new Modus();
        $form   = $this->createForm(new ModusType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Modus entity.
     *
     * @Route("/create", name="modus_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Modus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Modus();
        $form = $this->createForm(new ModusType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Modus entity.
     *
     * @Route("/{id}/edit", name="modus_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diesen Modus zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('modus_show', array('id' => $id)));
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Modus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modus entity.');
        }

        $editForm = $this->createForm(new ModusType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Modus entity.
     *
     * @Route("/{id}/update", name="modus_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Modus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Modus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ModusType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Modus entity.
     *
     * @Route("/{id}/delete", name="modus_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Modus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Modus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('modus'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
     /**
     * Legt fest, ob der User die Modusrunden verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit(){
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return TRUE;
        }
        return FALSE;
    }
}
