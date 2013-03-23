<?php

namespace Ligaweb\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    public function indexAction($name)
    {
        $this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');
        return $this->render('LigawebCoreBundle:Hello:index.html.twig', array('name' => $name));
    }
}