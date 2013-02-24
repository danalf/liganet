<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Ergebnis;
use Liganet\CoreBundle\Form\ErgebnisType;

/**
 * Ergebnis controller.
 *
 * @Route("/ergebnis")
 */
class ErgebnisController extends Controller
{
    /**
     * Lists all Ergebnis entities.
     *
     * @Route("/", name="ergebnis")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Ergebnis')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Ergebnis entity.
     *
     * @Route("/{id}/show", name="ergebnis_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Ergebnis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ergebnis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Ergebnis entity.
     *
     * @Route("/new", name="ergebnis_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ergebnis();
        $form   = $this->createForm(new ErgebnisType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Ergebnis entity.
     *
     * @Route("/create", name="ergebnis_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Ergebnis:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Ergebnis();
        $form = $this->createForm(new ErgebnisType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ergebnis_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ergebnis entity.
     *
     * @Route("/{id}/edit", name="ergebnis_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Ergebnis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ergebnis entity.');
        }

        $editForm = $this->createForm(new ErgebnisType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Ergebnis entity.
     *
     * @Route("/{id}/update", name="ergebnis_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Ergebnis:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Ergebnis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ergebnis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ErgebnisType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ergebnis_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ergebnis entity.
     *
     * @Route("/{id}/delete", name="ergebnis_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Ergebnis')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ergebnis entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ergebnis'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
