<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Spieler;
use AppBundle\Entity\Verein;
use AppBundle\Entity\User;
use AppBundle\Form\SpielerType;

/**
 * Spieler controller.
 *
 * @Route("/spieler")
 */
class SpielerController extends Controller
{
    /**
     * Lists all Spieler entities.
     *
     * @Route("/", name="spieler_index")
     * @Method("GET")
     * @Security("has_role('ROLE_REGION_MANAGEMENT')")
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();

        $spielers = $em->getRepository('AppBundle:Spieler')->findAll();

        return $this->render('spieler/index.html.twig', array(
            'spielers' => $spielers,
        ));
    }

    /**
     * Creates a new Spieler entity.
     *
     * @Route("/new/{verein_id}", name="spieler_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("verein", options={"mapping": {"verein_id": "id"}})
     */
    public function newAction(Request $request, Verein $verein)
    {
        $this->denyAccessUnlessGranted('edit', $verein);
        
        $spieler = new Spieler();
        $spieler->setVerein($verein);
        $form = $this->createForm('AppBundle\Form\SpielerType', $spieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieler);
            $em->flush();

            return $this->redirectToRoute('spieler_show', array('id' => $spieler->getId()));
        }

        return $this->render('spieler/new.html.twig', array(
            'spieler' => $spieler,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Spieler entity.
     *
     * @Route("/{id}", name="spieler_show")
     * 
     */
    public function showAction(Spieler $spieler)
    {        
        $this->denyAccessUnlessGranted('view', $spieler);
        
        $deleteForm = $this->createDeleteForm($spieler);

        return $this->render('spieler/show.html.twig', array(
            'spieler' => $spieler,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Spieler entity.
     *
     * @Route("/{id}/edit", name="spieler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Spieler $spieler)
    {
        $this->denyAccessUnlessGranted('edit', $spieler);
        
        $deleteForm = $this->createDeleteForm($spieler);
        $editForm = $this->createForm('AppBundle\Form\SpielerType', $spieler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spieler);
            $em->flush();

            return $this->redirectToRoute('spieler_show', array('id' => $spieler->getId()));
        }

        return $this->render('spieler/edit.html.twig', array(
            'spieler' => $spieler,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Spieler entity.
     *
     * @Route("/{id}", name="spieler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Spieler $spieler)
    {
        $this->denyAccessUnlessGranted('edit', $spieler);
        
        $form = $this->createDeleteForm($spieler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spieler);
            $em->flush();
        }

        return $this->redirectToRoute('spieler_index');
    }

    /**
     * Creates a form to delete a Spieler entity.
     *
     * @param Spieler $spieler The Spieler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Spieler $spieler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spieler_delete', array('id' => $spieler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Legt einen SPieler als User an
     *
     * @Route("/{id}/createUser", name="spieler_createuser")
     */
    public function createUserAction(Spieler $spieler) {

        $userManager = $this->container->get('fos_user.user_manager');
        $user_exist = $userManager->findUserBy(array('spieler' => $spieler->getId()));
        if (isset($user_exist)) {
            $this->get('session')->getFlashBag()->add('error', 'Der Spieler ist bereis als User angelegt');
            return $this->redirectToRoute('spieler_show', array('id' => $id));
        }

        if (!$spieler) {
            throw $this->createNotFoundException('Unable to find Spieler entity.');
        }
        $email = $spieler->getEmail();
        if (!strrpos($email, "@")) {
            $this->get('session')->getFlashBag()->add('error', 'Für den Spieler wurde keine Email hinterlegt.');
            return $this->redirectToRoute('spieler_show', array('id' => $id));
        }
        
        /**
         * @var User 
         */
        $user = $userManager->createUser();
        $user->setUsername($spieler->__toString());
        $user->setPassword("rftgknxdr kcjgs undrgtfg nfr");
        $user->setSpieler($spieler);
        $user->setEmail($spieler->getEmail());
        $user->setEnabled(true);
        $userManager->updateUser($user);

        $message = (new \Swift_Message())
                ->setSubject('Willkommen zum Liganet')
                ->setFrom('admin@liga-net.de')
                ->setTo($user->getEmail())
                ->setBody(
                $this->renderView(
                        'admin/emailNew.txt.twig', array('user' => $user)
                )
        );
        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('success', 'Der Spieler wurde als User hinzugefügt.');
        $deleteForm = $this->createDeleteForm($spieler);

        return $this->redirectToRoute('spieler_show', array('id' => $spieler->getId()));
    }
}
