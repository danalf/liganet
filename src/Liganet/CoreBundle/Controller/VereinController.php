<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Verein;
use Liganet\CoreBundle\Form\VereinType;

/**
 * Verein controller.
 *
 * @Route("/verein")
 */
class VereinController extends Controller
{
    /**
     * Lists all Verein entities.
     *
     * @Route("/", name="verein")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Verein')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Verein entity.
     *
     * @Route("/{id}/show", name="verein_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verein')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verein entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Verein entity.
     *
     * @Route("/new", name="verein_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Verein();
        $form   = $this->createForm(new VereinType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Verein entity.
     *
     * @Route("/create", name="verein_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Verein:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Verein();
        $form = $this->createForm(new VereinType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('verein_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Verein entity.
     *
     * @Route("/{id}/edit", name="verein_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verein')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verein entity.');
        }

        $editForm = $this->createForm(new VereinType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Verein entity.
     *
     * @Route("/{id}/update", name="verein_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Verein:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Verein')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Verein entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VereinType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('verein_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Verein entity.
     *
     * @Route("/{id}/delete", name="verein_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Verein')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Verein entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('verein'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
