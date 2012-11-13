<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Spieler;
use Liganet\CoreBundle\Form\SpielerType;

/**
 * Spieler controller.
 *
 * @Route("/spieler")
 */
class SpielerController extends Controller {

    /**
     * Lists all Spieler entities.
     *
     * @Route("/", name="spieler")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Spieler')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Spieler entity.
     *
     * @Route("/{id}/show", name="spieler_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Der Spieler wurde nicht gefunden.');
            return $this->redirect($this->generateUrl('spieler'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Spieler entity.
     *
     * @Route("/new", name="spieler_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Spieler();
        $form = $this->createForm(new SpielerType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Spieler entity.
     *
     * @Route("/create", name="spieler_create")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Spieler:new.html.twig")
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = new Spieler();
        $entity->setBestaetigt(false);
        $bearbeiter = $em->getRepository('LiganetCoreBundle:Spieler')->find($this->getUser()->getSpieler());
        $entity->setVeraendertvon($bearbeiter);

        $form = $this->createForm(new SpielerType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Der Spieler wurde angelegt');
            return $this->redirect($this->generateUrl('spieler_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Spieler entity.
     *
     * @Route("/{id}/edit", name="spieler_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Der Spieler wurde nicht gefunden.');
            throw $this->createNotFoundException('Unable to find Spieler entity.');
        }

        $editForm = $this->createForm(new SpielerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Spieler entity.
     *
     * @Route("/{id}/update", name="spieler_update")
     * @Method("POST")
     * @Template("LiganetCoreBundle:Spieler:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Der Spieler wurde nicht gefunden.');
            throw $this->createNotFoundException('Unable to find Spieler entity.');
        }

        $bearbeiter = $em->getRepository('LiganetCoreBundle:Spieler')->find($this->getUser()->getSpieler());
        $entity->setVeraendertvon($bearbeiter);
        //Bei einer Rolle kleiner als Ligaleiter wird Bestaetig auf false gesetzt
        if (!$this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            $entity->setBestaetigt(false);
        }


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpielerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Die Änderungen wurden gespeichert');

            return $this->redirect($this->generateUrl('spieler_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Spieler entity.
     *
     * @Route("/{id}/delete", name="spieler_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Spieler entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spieler'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * @Template()
     */
    public function showInMenuAction() {
        $user = $this->getUser();
        $id = $user->getSpieler();
        if(isset($id)){
            $em = $this->getDoctrine()->getManager();
        $spieler = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);
        } else{
            $spieler=new Spieler;
        }
        
        
        
        return array('spieler' => $spieler, 'user' => $user);
    }
    
    private function isGrantedEdit($spieler){
        
        return FALSE;
    }

}
