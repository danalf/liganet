<?php

namespace Liganet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        if ($verband == false) {
            $this->get('session')->getFlashBag()->add('error', 'Datensatz nicht vorhanden!');
            return $this->redirect($this->generateUrl('verband'));
        }
        return $this->render('LiganetCoreBundle:Verband:show.html.twig', array('verband' => $verband));
    }

    public function deleteAction($id) {
        if (false === $this->get('security.context')->isGranted('ROLE_UNION_MANAGEMENT')) {
            throw new AccessDeniedException();
        }
        $verband = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Verband')
                ->find($id);
        if ($verband == false) {
            $this->get('session')->getFlashBag()->add('error', 'Datensatz nicht vorhanden!');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($verband);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Datensatz wurde gelöscht.');
        }
        return $this->redirect($this->generateUrl('verband'));
    }

    public function addAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_UNION_MANAGEMENT')) {
            throw new AccessDeniedException();
        }
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

    public function editAction($id) {
        $verband = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Verband')
                ->find($id);
        if ($verband == false) {
            $this->get('session')->getFlashBag()->add('error', 'Datensatz nicht vorhanden!');
            return $this->redirect($this->generateUrl('verband'));
        }
        $form = $this->createForm(new VerbandType(), $verband);

        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($verband);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Die Änderungen wurden gespeichert!');


                return $this->redirect($this->generateUrl('verband'));
            }
        }
        return $this->render('LiganetCoreBundle:Verband:edit.html.twig', array(
                    'form' => $form->createView(),
                    'verband' => $verband,
                ));
    }

    public function showStartAction($max = 3) {
        $verband = $this->getDoctrine()
                ->getRepository('LiganetCoreBundle:Verband')
                ->findAll();

        return $this->render('LiganetCoreBundle:Verband:showStart.html.twig', array('verbaende' => $verband));
    }

}