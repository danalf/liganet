<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\ModusRunden;
use Liganet\CoreBundle\Form\ModusRundenType;

/**
 * ModusRunden controller.
 *
 * @Route("/modusrunden")
 */
class ModusRundenController extends Controller
{
    /**
     * Lists all ModusRunden entities.
     *
     * @Route("/", name="modusrunden")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:ModusRunden')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a ModusRunden entity.
     *
     * @Route("/{id}/show", name="modusrunden_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:ModusRunden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModusRunden entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new ModusRunden entity.
     *
     * @Route("/new", name="modusrunden_new")
     * @Template()
     */
    public function newAction()
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neue Modusrunden anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('modusrunden'));
        }
        $entity = new ModusRunden();
        $form   = $this->createForm(new ModusRundenType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new ModusRunden entity.
     *
     * @Route("/create", name="modusrunden_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:ModusRunden:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ModusRunden();
        $form = $this->createForm(new ModusRundenType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modusrunden_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ModusRunden entity.
     *
     * @Route("/{id}/edit", name="modusrunden_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diese Modusrunde zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('modusrunde_show', array('id' => $id)));
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:ModusRunden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModusRunden entity.');
        }

        $editForm = $this->createForm(new ModusRundenType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ModusRunden entity.
     *
     * @Route("/{id}/update", name="modusrunden_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:ModusRunden:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:ModusRunden')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModusRunden entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ModusRundenType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modusrunden_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ModusRunden entity.
     *
     * @Route("/{id}/delete", name="modusrunden_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:ModusRunden')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ModusRunden entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('modusrunden'));
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
