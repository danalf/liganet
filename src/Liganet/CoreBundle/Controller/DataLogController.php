<?php

namespace Liganet\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Liganet\CoreBundle\Entity\DataLog;

/**
 * DataLog controller.
 *
 * @Route("/datalog")
 */
class DataLogController extends Controller
{
    /**
     * Lists all DataLog entities.
     *
     * @Route("/", name="datalog")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity_array=array();

        $entities = $em->getRepository('LiganetCoreBundle:DataLog')->findAll();
        foreach ($entities as $entity) {
            array_push($entity_array, $entity->toArray());
        }
        
        return array(
            'entities' => $entity_array,
        );
    }

    /**
     * Finds and displays a DataLog entity.
     *
     * @Route("/{id}/show", name="datalog_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiganetCoreBundle:DataLog')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataLog entity.');
        }

        $entity=$entity->toArray();

        return array(
            'entity'      => $entity,
        );
    }

}
