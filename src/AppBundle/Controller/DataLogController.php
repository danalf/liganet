<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\DataLog;

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
     * @Route("/", name="datalog_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity_array=array();

        $entities = $em->getRepository('AppBundle:DataLog')->findAll();
        $i=0;
        foreach ($entities as $entity) {
            $i++;
            if($i>100){
                break;
            }
            array_push($entity_array, $entity->toArray());
        }
        
        return $this->render('datalog/index.html.twig', array(
            'entities' => $entity_array,
        ));
    }

    /**
     * Finds and displays a DataLog entity.
     *
     * @Route("/{id}/show", name="datalog_show")
     */
    public function showAction(DataLog $datalog)
    {

        $entity=$datalog->toArray();
        
        return $this->render('datalog/index.html.twig', array(
            'entity' => $entity,
        ));
    }

}
