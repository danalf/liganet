<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Liganet\CoreBundle\Entity\Verband;
use Liganet\CoreBundle\Entity\Document;
use Liganet\CoreBundle\Form\Type\VerbandType;


class VerbandController extends Controller {

    public function indexAction() {
        $verband = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Verband')
                ->findAll();
        return $this->render('LiganetCoreBundle:Verband:index.html.twig', array('verband' => $verband));
    }

    public function showAction($id) {
        $verband = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Verband')
                ->find($id);
        return $this->render('LiganetCoreBundle:Verband:show.html.twig', array('verband' => $verband));
    }

    public function addAction() {
        $verband = new Verband;
        $form = $this->createForm(new VerbandType(), $verband);

        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($verband);
                $em->flush();

                return $this->redirect($this->generateUrl('verband'));
            }
        }
        return $this->render('LiganetCoreBundle:Verband:add.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

}