<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Region;
use AppBundle\Entity\Verband;
use AppBundle\Form\RegionType;

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
     * @Route("/", name="region_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regions = $em->getRepository('AppBundle:Region')->findAll();

        return $this->render('region/index.html.twig', array(
            'regions' => $regions,
        ));
    }

    /**
     * Creates a new Region entity.
     *
     * @Route("/new/{verband_id}", name="region_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_UNION_MANAGEMENT')")
     * @ParamConverter("verband", options={"mapping": {"verband_id": "id"}})
     */
    public function newAction(Request $request, Verband $verband)
    {
        $region = new Region();
        $region->setVerband($verband);
        $form = $this->createForm('AppBundle\Form\RegionType', $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('region_show', array('id' => $region->getId()));
        }

        return $this->render('region/new.html.twig', array(
            'region' => $region,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Region entity.
     *
     * @Route("/{id}", name="region_show")
     * @Method("GET")
     */
    public function showAction(Region $region)
    {
        $deleteForm = $this->createDeleteForm($region);

        return $this->render('region/show.html.twig', array(
            'region' => $region,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Region entity.
     *
     * @Route("/{id}/edit", name="region_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_UNION_MANAGEMENT')")
     */
    public function editAction(Request $request, Region $region)
    {
        $deleteForm = $this->createDeleteForm($region);
        $editForm = $this->createForm('AppBundle\Form\RegionType', $region);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('region_show', array('id' => $region->getId()));
        }

        return $this->render('region/edit.html.twig', array(
            'region' => $region,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Region entity.
     *
     * @Route("/{id}", name="region_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_UNION_MANAGEMENT')")
     */
    public function deleteAction(Request $request, Region $region)
    {
        $form = $this->createDeleteForm($region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($region);
            $em->flush();
        }

        return $this->redirectToRoute('region_index');
    }

    /**
     * Creates a form to delete a Region entity.
     *
     * @param Region $region The Region entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Region $region)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('region_delete', array('id' => $region->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
