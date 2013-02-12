<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Liga;
use Liganet\CoreBundle\Form\LigaType;

/**
 * Liga controller.
 *
 * @Route("/liga")
 */
class LigaController extends Controller
{
    /**
     * Lists all Liga entities.
     *
     * @Route("/", name="liga")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Liga')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Liga entity.
     *
     * @Route("/{id}/show", name="liga_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Liga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Liga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new Liga entity.
     *
     * @Route("/new", name="liga_new")
     * @Template()
     */
    public function newAction()
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neue Liga anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('liga'));
        }
        $entity = new Liga();
        $form   = $this->createForm(new LigaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Liga entity.
     *
     * @Route("/create", name="liga_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Liga:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Liga();
        $form = $this->createForm(new LigaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('liga_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Liga entity.
     *
     * @Route("/{id}/edit", name="liga_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diese Liga zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('liga_show', array('id' => $id)));
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Liga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Liga entity.');
        }

        $editForm = $this->createForm(new LigaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Liga entity.
     *
     * @Route("/{id}/update", name="liga_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Liga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Liga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Liga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LigaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('liga_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Liga entity.
     *
     * @Route("/{id}/delete", name="liga_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Liga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Liga entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('liga'));
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
        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            return TRUE;
        }
        return FALSE;
    }
}
