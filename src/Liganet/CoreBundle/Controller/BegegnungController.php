<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Begegnung;
use Liganet\CoreBundle\Form\BegegnungType;

/**
 * Begegnung controller.
 *
 * @Route("/begegnung")
 */
class BegegnungController extends Controller
{
    /**
     * Lists all Begegnung entities.
     *
     * @Route("/", name="begegnung")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Begegnung')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Begegnung entity.
     *
     * @Route("/{id}/show", name="begegnung_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Begegnung')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Begegnung entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Begegnung entity.
     *
     * @Route("/new", name="begegnung_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Begegnung();
        $form   = $this->createForm(new BegegnungType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Begegnung entity.
     *
     * @Route("/create", name="begegnung_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Begegnung:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Begegnung();
        $form = $this->createForm(new BegegnungType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('begegnung_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Begegnung entity.
     *
     * @Route("/{id}/edit", name="begegnung_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Begegnung')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Begegnung entity.');
        }

        $editForm = $this->createForm(new BegegnungType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Begegnung entity.
     *
     * @Route("/{id}/update", name="begegnung_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Begegnung:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Begegnung')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Begegnung entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BegegnungType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('begegnung_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Begegnung entity.
     *
     * @Route("/{id}/delete", name="begegnung_delete")
     * @Method("POST")
     */
    public function zzz_deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Begegnung')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Begegnung entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('begegnung'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
