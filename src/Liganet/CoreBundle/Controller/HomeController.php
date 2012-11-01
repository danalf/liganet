<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    public function indexAction() {
        return $this->render('LiganetCoreBundle:Home:index.html.twig');
    }

}
