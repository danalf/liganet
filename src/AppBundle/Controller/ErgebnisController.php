<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Spieler;

/**
 * Ergebnis controller.
 *
 * @Route("/ergebnis")
 */
class ErgebnisController extends Controller
{    
    /**
     * Lists all Spiele from one Spieler
     *
     * @Route("/spieler/{spieler_id}", name="ergebnis_spieler")
     * @Method({"GET", "POST"})
     * @ParamConverter("spieler", options={"mapping": {"spieler_id": "id"}})
     */
    public function showBySpielerAction(Spieler $spieler) {
        $em = $this->getDoctrine()->getManager();
        $ergebnisse = $em->getRepository('AppBundle:Ergebnis')->findBySpieler($spieler);
        
        return $this->render('ergebnis/showBySpieler.html.twig', array(
            'ergebnisse' => $ergebnisse,
            'spieler' => $spieler,
        ));

    }
    
    
}
