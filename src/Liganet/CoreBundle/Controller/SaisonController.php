<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Saison;
use Liganet\CoreBundle\Form\SaisonType;

/**
 * Saison controller.
 *
 * @Route("/saison")
 */
class SaisonController extends Controller
{
    /**
     * Lists all Saison entities.
     *
     * @Route("/", name="saison")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Saison')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Saison entity.
     *
     * @Route("/{id}/show", name="saison_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Saison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Saison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Saison entity.
     *
     * @Route("/new", name="saison_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Saison();
        $form   = $this->createForm(new SaisonType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Saison entity.
     *
     * @Route("/create", name="saison_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Saison:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Saison();
        $form = $this->createForm(new SaisonType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('saison_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Saison entity.
     *
     * @Route("/{id}/edit", name="saison_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Saison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Saison entity.');
        }

        $editForm = $this->createForm(new SaisonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Saison entity.
     *
     * @Route("/{id}/update", name="saison_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Saison:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Saison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Saison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SaisonType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('saison_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Saison entity.
     *
     * @Route("/{id}/delete", name="saison_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Saison')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Saison entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('saison'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
