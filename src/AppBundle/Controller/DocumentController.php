<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Document')->findAll();
        
        return $this->render('document/index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}/show", name="document_show")
     */
    public function showAction(Document $document)
    {
        $deleteForm = $this->createDeleteForm($document->getId());

        return $this->render('document/show.html.twig', array(
            'entity'      => $document,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Creates a new Docuemnt entity.
     *
     * @Route("/new", name="document_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $document=new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('document_show', array('id' => $document->getId()));
        }

        return $this->render('document/new.html.twig', array(
            'entity' => $document,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm(DocumentType::class, $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('document_show', array('id' => $document->getId()));
        }

        return $this->render('document/edit.html.twig', array(
            'entity' => $document,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * Creates a form to delete a Document entity.
     *
     * @param Document $document The Document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
