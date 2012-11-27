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
class MannschaftController extends Controller
{
    /**
     * Lists all Mannschaft entities.
     *
     * @Route("/", name="mannschaft")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Mannschaft')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Mannschaft entity.
     *
     * @Route("/{id}/show", name="mannschaft_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Mannschaft entity.
     *
     * @Route("/new", name="mannschaft_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mannschaft();
        $form   = $this->createForm(new MannschaftType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Mannschaft entity.
     *
     * @Route("/create", name="mannschaft_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Mannschaft:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Mannschaft();
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
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mannschaft entity.
     *
     * @Route("/{id}/edit", name="mannschaft_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Mannschaft')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mannschaft entity.');
        }
        
        $editForm = $this->createForm(new MannschaftType(array(), array('id' => $entity->getId())), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
    public function updateAction(Request $request, $id)
    {
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mannschaft entity.
     *
     * @Route("/{id}/delete", name="mannschaft_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
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

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
