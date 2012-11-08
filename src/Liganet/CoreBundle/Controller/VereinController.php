<?php

namespace Liganet\CoreBundle\Controller;

use Liganet\CoreBundle\Form\Type\VereinType;
use Liganet\CoreBundle\Entity\Verein;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VereinController extends Controller {

    public function addAction() {
        $verein = new Verein;
        $form = $this->createForm(new VereinType(), $verein);
        $request = $this->get('request');

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($verein);
                $em->flush();
            }
        }
        return $this->render('LiganetCoreBundle:Verein:add.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

}