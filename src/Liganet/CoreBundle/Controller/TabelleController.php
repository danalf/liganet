<?php

namespace Liganet\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Tabelle;

/**
 * Tabelle controller.
 *
 * @Route("/tabelle")
 */
class TabelleController extends Controller
{
    /**
     * Lists all Tabelle entities.
     *
     * @Route("/", name="tabelle")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Tabelle')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Tabelle entity.
     *
     * @Route("/{id}/show", name="tabelle_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Tabelle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tabelle entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
