<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Verein;
use AppBundle\Entity\Saison;
use AppBundle\Form\VereinType;

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
     * @Route("/", name="verein_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vereins = $em->getRepository('AppBundle:Verein')->findAll();

        return $this->render('verein/index.html.twig', array(
            'vereins' => $vereins,
        ));
    }

    /**
     * Creates a new Verein entity.
     *
     * @Route("/new", name="verein_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $verein = new Verein();
        $form = $this->createForm('AppBundle\Form\VereinType', $verein);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($verein);
            $em->flush();

            return $this->redirectToRoute('verein_show', array('id' => $verein->getId()));
        }

        return $this->render('verein/new.html.twig', array(
            'verein' => $verein,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Verein entity.
     *
     * @Route("/{id}", name="verein_show")
     * @Method("GET")
     */
    public function showAction(Verein $verein)
    {
        $this->denyAccessUnlessGranted('view', $verein);

        $deleteForm = $this->createDeleteForm($verein);

        $em = $this->getDoctrine()->getManager();
        $lastSaison = $em->getRepository('AppBundle:Saison')->findLastYear();

        return $this->render('verein/show.html.twig', array(
            'verein' => $verein,
            'lastSaison' => $lastSaison,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Verein entity.
     *
     * @Route("/{id}/edit", name="verein_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Verein $verein)
    {
        $this->denyAccessUnlessGranted('edit', $verein);
        $deleteForm = $this->createDeleteForm($verein);
        $editForm = $this->createForm('AppBundle\Form\VereinType', $verein);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($verein);
            $em->flush();

            return $this->redirectToRoute('verein_show', array('id' => $verein->getId()));
        }

        return $this->render('verein/edit.html.twig', array(
            'verein' => $verein,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Verein entity.
     *
     * @Route("/{id}", name="verein_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Verein $verein)
    {
        $this->denyAccessUnlessGranted('edit', $verein);
        $form = $this->createDeleteForm($verein);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($verein);
            $em->flush();
        }

        return $this->redirectToRoute('verein_index');
    }

    /**
     * Creates a form to delete a Verein entity.
     *
     * @param Verein $verein The Verein entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Verein $verein)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('verein_delete', array('id' => $verein->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
