<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\MannschaftSpieler;
use Liganet\CoreBundle\Form\MannschaftSpielerType;

/**
 * MannschaftSpieler controller.
 *
 * @Route("/mannschaftspieler")
 */
class MannschaftSpielerController extends Controller
{
    /**
     * Lists all MannschaftSpieler entities.
     *
     * @Route("/", name="mannschaftspieler")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a MannschaftSpieler entity.
     *
     * @Route("/{id}/show", name="mannschaftspieler_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new MannschaftSpieler entity.
     *
     * @Route("/new", name="mannschaftspieler_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MannschaftSpieler();
        $form   = $this->createForm(new MannschaftSpielerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new MannschaftSpieler entity.
     *
     * @Route("/create", name="mannschaftspieler_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:MannschaftSpieler:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new MannschaftSpieler();
        $form = $this->createForm(new MannschaftSpielerType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mannschaftspieler_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MannschaftSpieler entity.
     *
     * @Route("/{id}/edit", name="mannschaftspieler_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $editForm = $this->createForm(new MannschaftSpielerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MannschaftSpieler entity.
     *
     * @Route("/{id}/update", name="mannschaftspieler_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:MannschaftSpieler:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MannschaftSpielerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mannschaftspieler_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MannschaftSpieler entity.
     *
     * @Route("/{id}/delete", name="mannschaftspieler_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:MannschaftSpieler')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MannschaftSpieler entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mannschaftspieler'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
