<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Begegnung;
use AppBundle\Form\BegegnungType;

/**
 * Begegnung controller.
 *
 * @Route("/begegnung")
 */
class BegegnungController extends Controller
{

    /**
     * Displays a form to edit an existing Begegnung entity.
     *
     * @Route("/{id}/edit", name="begegnung_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Begegnung $begegnung)
    {
        //$this->get('session')->set('mannschaft1', $begegnung->getMannschaft1()->getId());
        //$this->get('session')->set('mannschaft2', $begegnung->getMannschaft2()->getId());
        $ergebnisse=$begegnung->getErgebnisse();
        //$editForm = $this->createForm(new BegegnungType($this->get('session')), $begegnung);
        $editForm = $this->createForm(BegegnungType::class, $begegnung);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $begegnung->setErgebnisse();
            $em->persist($begegnung);
            $em->flush();
            
            /* @var $berechnen \Liganet\CoreBundle\Services\berechnenErgebnisService */
            $berechnen = $this->get('app.util.berechnenErgebnis');
            $berechnen->setLigaSaison($begegnung->getSpielRunde()->getSpieltag()->getLigaSaison());
            $berechnen->makeTabellen();

            return $this->redirectToRoute('spielrunde_show', array('id' => $begegnung->getSpielRunde()->getId()));
        }

        return $this->render('begegnung/edit.html.twig', array(
            'begegnung' => $begegnung,
            'form' => $editForm->createView(),
        ));
    }
}
