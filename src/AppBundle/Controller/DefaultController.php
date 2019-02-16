<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/neu", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $sync=$this->get("app.util.sync.spieler");
        $sync->getNewDataSets();
        $em = $this->get('doctrine')->getManager('extern');
        $spieler = $em->getRepository('AppBundle\Entity\SpielerExtern')->findAll();
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'spielers' => $spielers,
        ));
    }
}
