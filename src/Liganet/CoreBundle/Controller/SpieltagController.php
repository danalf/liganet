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
class SpieltagController extends Controller
{
    /**
     * Lists all Spieltag entities.
     *
     * @Route("/", name="spieltag")
     * @Template()
     */
    public function indexAction()
    {
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
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spieltag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new Spieltag entity.
     *
     * @Route("/new", name="spieltag_new")
     * @Template()
     */
    public function newAction()
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neuen Spieltag anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spieltag'));
        }
        $entity = new Spieltag();
        $form   = $this->createForm(new SpieltagType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Spieltag entity.
     *
     * @Route("/create", name="spieltag_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Spieltag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Spieltag();
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
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Spieltag entity.
     *
     * @Route("/{id}/edit", name="spieltag_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
    public function updateAction(Request $request, $id)
    {
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Spieltag entity.
     *
     * @Route("/{id}/delete", name="spieltag_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
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

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Legt fest, ob der User (den) Spieltag verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit(){
        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            return TRUE;
        }
        return FALSE;
    }
    
}
