<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Spieler;
use Liganet\CoreBundle\Form\SpielerType;
use Liganet\CoreBundle\Entity\DataLog;

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
            'isGrantedEdit' => $this->isGrantedEdit()
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
        $log = $em->getRepository('LiganetCoreBundle:DataLog')->findBy(array('entity_id' => $id, 'entity_type' => get_class($entity)));

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'log'   =>  $log,
            'delete_form' => $deleteForm->createView(),
            'isGrantedEdit' => $this->isGrantedEdit($entity->getVerein())
        );
    }

    /**
     * Displays a form to create a new Spieler entity.
     *
     * @Route("/new/verein/{id}", name="spieler_new")
     * @Template()
     */
    public function newAction($id = 0) {
        if (!$this->isGrantedEdit()) {
            $this->get('session')->getFlashBag()->add('error', 'Neuen Spieler anlegen ist für dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('_home'));
        }
        $entity = new Spieler();
        //Verein suchen
        if ($id > 0) {
            $em = $this->getDoctrine()->getManager();
            $verein = $em->getRepository('LiganetCoreBundle:Verein')->find($id);
            $entity->setVerein($verein);
        }

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

        $entity = $this->setUpdateInformation($entity);

        if ($form->isValid()) {
            $unitOfWork = $em->getUnitOfWork();
            $unitOfWork->computeChangeSets();
            $changes = $unitOfWork->getEntityChangeSet($entity);
            $log=new DataLog();
            $log->setUser($this->getUser());
            $log->setChanges($changes);
            $em->persist($entity);
            $em->flush();
            $log->setEntityId($entity->getId());
            $log->setEntityType(get_class($entity));
            $em->persist($log);
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

        if (!$this->isGrantedEdit($entity->getVerein())) {
            $this->get('session')->getFlashBag()->add('error', 'Diesen Spieler zu editieren ist für Dich nicht nicht erlaubt');
            return $this->redirect($this->generateUrl('spieler_show', array('id' => $id)));
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

        $entity = $this->setUpdateInformation($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SpielerType(), $entity);
        $editForm->bind($request);


        if ($editForm->isValid()) {
            //Änderungen im Log speichern
            $unitOfWork = $em->getUnitOfWork();
            $unitOfWork->computeChangeSets();
            $changes = $unitOfWork->getEntityChangeSet($entity);
            $log=new DataLog();
            $log->setUser($this->getUser());
            $log->setChanges($changes);
            $log->setEntityId($entity->getId());
            $log->setEntityType(get_class($entity));
            $em->persist($log);
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
     * Setzt die bestätigt und Bearbeitet-Variable des Spielers
     * @param \Liganet\CoreBundle\Entity\Spieler $entity
     * @return \Liganet\CoreBundle\Entity\Spieler
     */
    private function setUpdateInformation(Spieler $entity) {
        $em = $this->getDoctrine()->getManager();
        $bearbeiter_id = $em->getRepository('LiganetCoreBundle:Spieler')->find($this->getUser()->getSpieler());
        $bearbeiter = $em->getRepository('LiganetCoreBundle:Spieler')->find($bearbeiter_id);
        $entity->setVeraendertvon($bearbeiter);
        $entity->setVeraendertam();
        //Bei einer Rolle kleiner als Staffelleiter wird Bestaetig auf false gesetzt
        if (!$this->get('security.context')->isGranted('ROLE_LEAGUE_MANAGEMENT')) {
            $entity->setBestaetigt(false);
        } else {
            $entity->setBestaetigt(true);
        }
        return $entity;
    }

    /**
     * Deletes a Spieler entity.
     *
     * @Route("/{id}/delete", name="spieler_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $this->get('session')->getFlashBag()->add('error', 'Löschen ist für dich nicht erlaubt');
            return $this->redirect($this->generateUrl('spieler'));
        }
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
            $this->get('session')->getFlashBag()->add('success', 'Der Spieler wurde gelöscht');
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
        $spieler = $this->getUserAsSpieler();

        return array('spieler' => $spieler, 'user' => $this->getUser());
    }

    /**
     * @Template()
     */
    public function showStartAction() {
        $spieler = $this->getUserAsSpieler();

        return array('spieler' => $spieler);
    }

    /**
     * Legt fest, ob der User (den) Verein verändern darf oder nicht
     * @param type $spieler
     * @return boolean
     */
    private function isGrantedEdit(\Liganet\CoreBundle\Entity\Verein $verein = NULL) {
        if ($this->get('security.context')->isGranted('ROLE_REGION_MANAGEMENT')) {
            return TRUE;
        }
        if (isset($verein)) {
            foreach ($verein->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
            foreach ($verein->getRegion()->getLeiter() as $leiter) {
                if ($this->getUser()->getSpieler() == $leiter->getId())
                    return TRUE;
            }
        };

        return FALSE;
    }

    /**
     * Gibt das Spieler-Objekt des Users zurück
     * @return \Liganet\CoreBundle\Entity\Spieler
     */
    private function getUserAsSpieler() {
        $user = $this->getUser();
        $id = $user->getSpieler();
        if (isset($id)) {
            $em = $this->getDoctrine()->getManager();
            $spieler = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);
        } else {
            $spieler = new Spieler;
        }
        return $spieler;
    }

    /**
     * Zeigt eine Spielerliste an
     *
     * @Route("/{id}/showList", name="spieler_showlist")
     * @Template()
     */
    public function showListAction($id) {
        $em = $this->getDoctrine()->getManager();
        $verein = $em->getRepository('LiganetCoreBundle:Verein')->find($id);
        $entities = $em->getRepository('LiganetCoreBundle:Spieler')->findAllByVereinIdOrdered($id);

        return array(
            'entities' => $entities,
            'verein' => $verein,
            'isGrantedEdit' => $this->isGrantedEdit($verein)
        );
    }

    /**
     * Zeigt eine Spielerliste an
     *
     * @Route("/{id}/createUser", name="spieler_createuser")
     */
    public function createUserAction($id) {

        $userManager = $this->container->get('fos_user.user_manager');
        $user_exist = $userManager->findUserBy(array('spieler' => $id));
        if (isset($user_exist)) {
            $this->get('session')->getFlashBag()->add('error', 'Der Spieler ist bereis als User angelegt');
            return $this->redirect($this->generateUrl('spieler_show', array('id' => $id)));
        }
        $em = $this->getDoctrine()->getManager();
        $spieler = $em->getRepository('LiganetCoreBundle:Spieler')->find($id);

        if (!$spieler) {
            throw $this->createNotFoundException('Unable to find Spieler entity.');
        }
        $email = $spieler->getEmail();
        if (!strrpos($email, "@")) {
            $this->get('session')->getFlashBag()->add('error', 'Für den Spieler wurde keine Email hinterlegt.');
            return $this->redirect($this->generateUrl('spieler_show', array('id' => $id)));
        }
        $user = new \Liganet\UserBundle\Entity\User;
        $user = $userManager->createUser();
        $user->setUsername($spieler);
        $user->setPassword("rftgknxdr kcjgs undrgtfg nfr");
        $user->setSpieler($spieler);
        $user->setEmail($spieler->getEmail());
        $user->setEnabled(true);

        $userManager->updateUser($user);

        $message = \Swift_Message::newInstance()
                ->setSubject('Willkommen zum Liganet')
                ->setFrom('admin@liga-net.de')
                ->setTo($user->getEmail())
                ->setBody(
                $this->renderView(
                        'LiganetCoreBundle:Admin:emailNew.txt.twig', array('user' => $user)
                )
        );
        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('success', 'Der Spieler wurde als User hinzugefügt.');
        return $this->redirect($this->generateUrl('spieler_show', array('id' => $id)));
    }
    
    /**
     * Lists all Spieler entities of one region
     *
     * @Route("/region/{region_id}", name="spieler_region")
     * @Template("LiganetCoreBundle:Spieler:index.html.twig")
     */
    public function showRegionAction($region_id) {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('LiganetCoreBundle:Spieler')->findAllByRegionIdOrdered($region_id);


        return array(
            'entities' => $entities,
            'isGrantedEdit' => $this->isGrantedEdit()
        );
    }
    
    
    
    

}
