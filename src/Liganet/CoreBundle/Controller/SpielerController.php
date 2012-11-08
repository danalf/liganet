<?php

namespace Liganet\CoreBundle\Controller;

use Liganet\CoreBundle\Form\Type\SpielerType;
use Liganet\CoreBundle\Entity\Spieler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SpielerController extends Controller {

    public function showAllAction() {
        $spieler = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Spieler')
                ->findAll();
        return $this->render('LiganetCoreBundle:Spieler:showAll.html.twig', array('spieler' => $spieler));
    }

    public function showAction($id) {
        $spieler = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Spieler')
                ->find($id);
        if (!$spieler) {
            throw $this->createNotFoundException('No spieler found for id ' . $id);
        }
        return $this->render('LiganetCoreBundle:Spieler:show.html.twig', array('spieler' => $spieler));
    }

    public function addAction() {
        $spieler = new Spieler;
        $form = $this->createForm(new SpielerType(), $spieler);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($spieler);
                $em->flush();
            }
        }
        return $this->render('LiganetCoreBundle:Spieler:add.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function responseAction() {
        $spieler = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Spieler')
                ->findAll();
        $response = new Response();
        $response->setContent(json_encode($this->toArray($spieler)));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');

        return new Response($response);
    }

    public function responseXMLAction() {
        $spieler = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Spieler')
                ->findAll();
        //$response = new Response();
        //$response->headers->set('Content-type', 'application/xml; charset=utf-8');
        //$response->setContent();

        return new Response($this->render('LiganetCoreBundle:Spieler:responseXML.xml.twig', array('spieler' => $spieler)),
                        200,
                        array('Content-Type' => 'application/xml')
        );
        //return $response;
        //return $this->render('LiganetCoreBundle:Spieler:responseXML.xml.twig', array('spieler' => $spieler));
    }

    private function toArray($spieler) {
        $arr = array();
        foreach ($spieler as $sp) {
            $arr[] = $sp->getArray();
        }
        return $arr;
    }

}