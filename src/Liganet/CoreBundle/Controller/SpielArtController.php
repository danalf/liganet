<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\SpielArt;
use Liganet\CoreBundle\Form\SpielArtType;

/**
 * SpielArt controller.
 *
 * @Route("/spielart")
 */
class SpielArtController extends Controller
{
    /**
     * Lists all SpielArt entities.
     *
     * @Route("/", name="spielart")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:SpielArt')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a SpielArt entity.
     *
     * @Route("/{id}/show", name="spielart_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielArt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielArt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new SpielArt entity.
     *
     * @Route("/new", name="spielart_new")
     * @Template()
     */
    public function newAction()
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neue Spielart anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spielart'));
        }
        $entity = new SpielArt();
        $form   = $this->createForm(new SpielArtType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SpielArt entity.
     *
     * @Route("/create", name="spielart_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielArt:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SpielArt();
        $form = $this->createForm(new SpielArtType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielart_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SpielArt entity.
     *
     * @Route("/{id}/edit", name="spielart_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diese Spielart zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spielart_show', array('id' => $id)));
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielArt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielArt entity.');
        }

        $editForm = $this->createForm(new SpielArtType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SpielArt entity.
     *
     * @Route("/{id}/update", name="spielart_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielArt:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielArt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielArt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpielArtType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielart_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SpielArt entity.
     *
     * @Route("/{id}/delete", name="spielart_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:SpielArt')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpielArt entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spielart'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
       /**
     * Legt fest, ob der User die Speilart verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit(){
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return TRUE;
        }
        return FALSE;
    }
}
