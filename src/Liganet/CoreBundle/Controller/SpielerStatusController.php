<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\SpielerStatus;
use Liganet\CoreBundle\Form\SpielerStatusType;

/**
 * SpielerStatus controller.
 *
 * @Route("/spielerstatus")
 */
class SpielerStatusController extends Controller
{
    /**
     * Lists all SpielerStatus entities.
     *
     * @Route("/", name="spielerstatus")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:SpielerStatus')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SpielerStatus entity.
     *
     * @Route("/{id}/show", name="spielerstatus_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielerStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielerStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new SpielerStatus entity.
     *
     * @Route("/new", name="spielerstatus_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SpielerStatus();
        $form   = $this->createForm(new SpielerStatusType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SpielerStatus entity.
     *
     * @Route("/create", name="spielerstatus_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielerStatus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SpielerStatus();
        $form = $this->createForm(new SpielerStatusType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielerstatus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SpielerStatus entity.
     *
     * @Route("/{id}/edit", name="spielerstatus_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielerStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielerStatus entity.');
        }

        $editForm = $this->createForm(new SpielerStatusType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SpielerStatus entity.
     *
     * @Route("/{id}/update", name="spielerstatus_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielerStatus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielerStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielerStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpielerStatusType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielerstatus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SpielerStatus entity.
     *
     * @Route("/{id}/delete", name="spielerstatus_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:SpielerStatus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpielerStatus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spielerstatus'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
