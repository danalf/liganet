<?php

namespace Liganet\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\Anrede;

/**
 * Anrede controller.
 *
 * @Route("/anrede")
 */
class AnredeController extends Controller
{
    /**
     * Lists all Anrede entities.
     *
     * @Route("/", name="anrede")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiganetCoreBundle:Anrede')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Anrede entity.
     *
     * @Route("/{id}/show", name="anrede_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:Anrede')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Anrede entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
