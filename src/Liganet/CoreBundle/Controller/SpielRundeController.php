<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\SpielRunde;
use Liganet\CoreBundle\Form\SpielRundeType;

/**
 * SpielRunde controller.
 *
 * @Route("/spielrunde")
 */
class SpielRundeController extends Controller
{
    /**
     * Lists all SpielRunde entities.
     *
     * @Route("/", name="spielrunde")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:SpielRunde')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SpielRunde entity.
     *
     * @Route("/{id}/show", name="spielrunde_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielRunde')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielRunde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new SpielRunde entity.
     *
     * @Route("/new", name="spielrunde_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SpielRunde();
        $form   = $this->createForm(new SpielRundeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SpielRunde entity.
     *
     * @Route("/create", name="spielrunde_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielRunde:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SpielRunde();
        $form = $this->createForm(new SpielRundeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielrunde_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SpielRunde entity.
     *
     * @Route("/{id}/edit", name="spielrunde_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielRunde')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielRunde entity.');
        }

        $editForm = $this->createForm(new SpielRundeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SpielRunde entity.
     *
     * @Route("/{id}/update", name="spielrunde_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:SpielRunde:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:SpielRunde')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpielRunde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpielRundeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spielrunde_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SpielRunde entity.
     *
     * @Route("/{id}/delete", name="spielrunde_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:SpielRunde')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpielRunde entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spielrunde'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
