<?php

namespace Liganet\CoreBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Liganet\CoreBundle\Entity\Region;
//use Liganet\CoreBundle\Entity\Document;
use Liganet\CoreBundle\Form\Type\RegionType;

class RegionController extends Controller {

    public function indexAction() {
        $region = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Region')
                ->findAll();
        return $this->render('LiganetCoreBundle:Region:index.html.twig', array('region' => $region));
    }

    public function showAction($id) {
        $region = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Region')
                ->find($id);
        return $this->render('LiganetCoreBundle:Region:show.html.twig', array('region' => $region));
    }

    public function addAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        
        if ($id == 0) {
            $region = new Region;
        } else {
            $region = $em
                    ->getRepository('LiganetCoreBundle:Region')
                    ->find($id);
        }
        $form = $this->createForm(new RegionType(), $region);
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($region);
                $em->flush();

                return $this->redirect($this->generateUrl('region'));
            }
        }
        return $this->render('LiganetCoreBundle:Region:add.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

}