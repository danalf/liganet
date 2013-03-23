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
            'isGrantedEdit' => $this->isGrantedEdit()
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
            'isGrantedEdit' => $this->isGrantedEdit($entity->getSpieltag()->getLigaSaison())
        );
    }

    /**
     * Displays a form to create a new SpielRunde entity.
     *
     * @Route("/new/spieltag/{spieltag_id}", name="spielrunde_new")
     * @Template()
     */
    public function newAction($spieltag_id=0)
    {
        if(!$this->isGrantedEdit()){
            $this->get('session')->getFlashBag()->add('error', 'Neue Spielrunde anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spielrunde'));
        }
        $entity = new SpielRunde();
        
        if($spieltag_id>0){
            $em = $this->getDoctrine()->getManager();
        $spieltag = $em->getRepository('LiganetCoreBundle:Spieltag')->find($spieltag_id);
        $entity->setSpieltag($spieltag);
        }
        
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
        if(!$this->isGrantedEdit($entity->getSpieltag()->getLigaSaison())){
            $this->get('session')->getFlashBag()->add('error', 'Diese Spielrunde zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spielrunde_show', array('id' => $id)));
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
    
    private function isGrantedEdit(\Liganet\CoreBundle\Entity\LigaSaison $ligasaison=  NULL) {
//        if ($this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
//            return TRUE;
//        }
        if (isset($ligasaison)) {
            foreach ($ligasaison->getStaffelleiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
            foreach ($ligasaison->getLiga()->getRegion()->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
        }
        return FALSE;
    }

  
    
    /**
     * Zeigt die Runden eines Spieltags an
     *
     * @Route("/{spieltag_id}/showList", name="spielrunde_showlist")
     * @Template()
     */
    public function showListAction($spieltag_id) {
        $em = $this->getDoctrine()->getManager();
        $spieltag = $em->getRepository('LiganetCoreBundle:Spieltag')->find($spieltag_id);
        $entities=$spieltag->getRunden();
        
        return array(
            'entities'      => $entities,
            'spieltag'        => $spieltag,
            'isGrantedEdit' => $this->isGrantedEdit($spieltag->getLigaSaison())
        );
    }
}
