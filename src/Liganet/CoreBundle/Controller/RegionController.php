<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Region;
use Liganet\CoreBundle\Form\RegionType;

/**
 * Region controller.
 *
 * @Route("/region")
 */
class RegionController extends Controller
{
    /**
     * Lists all Region entities.
     *
     * @Route("/", name="region")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Region')->findAll();

        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Finds and displays a Region entity.
     *
     * @Route("/{id}/show", name="region_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    /**
     * Displays a form to create a new Region entity.
     *
     * @Route("/new/verband/{verband_id}", name="region_new")
     * @Template()
     */
    public function newAction($verband_id=NULL)
    {
        
        $entity = new Region();
        
        if ($verband_id > 0) {
            $em = $this->getDoctrine()->getManager();
            $verband = $em->getRepository('LiganetCoreBundle:Verband')->find($verband_id);
            $entity->setVerband($verband);
        }
        
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neue Region anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('region'));
        }
        
        $form   = $this->createForm(new RegionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Region entity.
     *
     * @Route("/create", name="region_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Region:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Region();
        $form = $this->createForm(new RegionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('region_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Region entity.
     *
     * @Route("/{id}/edit", name="region_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Diese Region zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('region_show', array('id' => $id)));
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm = $this->createForm(new RegionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Region entity.
     *
     * @Route("/{id}/update", name="region_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Region:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RegionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('region_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Region entity.
     *
     * @Route("/{id}/delete", name="region_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Region')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Region entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('region'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
       /**
     * Legt fest, ob der User die Region verändern darf oder nicht
     * @return boolean
     */
    private function isGrantedEdit(){
        if ($this->get('security.context')->isGranted('ROLE_REGION_MANAGEMENT')) {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 
     *
     * @Route("/{verband_id}/showList", name="region_showlist")
     * @Template()
     */
    public function showListAction($verband_id) {
        $em = $this->getDoctrine()->getManager();
        $verband = $em->getRepository('LiganetCoreBundle:Verband')->find($verband_id);

        return array(
            'verband' => $verband,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }

    
}
