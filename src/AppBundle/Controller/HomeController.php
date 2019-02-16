<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller {

    /**
     * Start-Page
     *
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function indexAction() {
        return $this->render('home/index.html.twig');
    }

}
