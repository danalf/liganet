<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/neu", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $sync=$this->get("app.util.sync.verein");
        $sync->getNewDataSets();
        $em = $this->get('doctrine')->getManager('extern');
        $vereine = $em->getRepository('AppBundle\Entity\VereinExtern')->findAll();
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'vereine' => $vereine,
        ));
    }
}
