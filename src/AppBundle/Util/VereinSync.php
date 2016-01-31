<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Util;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of VereinSync
 *
 * @author alfredo
 */
class VereinSync
{
    private $doctrine;
    
    private $emDefault;
    
    private $emExtern;
    
    public function __construct($doctrine, EntityManagerInterface $emDefault, EntityManagerInterface $emExtern) {
        $this->doctrine = $doctrine;
        $this->emDefault = $emDefault;
        $this->emExtern = $emExtern;
    }
    
    public function getNewDataSets(){
        $vereine = $this->doctrine
            ->getRepository('AppBundle\Entity\VereinExtern', 'extern')
            ->findAll()
        ;
        //$vereine = $this->emExtern->getRepository('AppBundle\Entity\VereinExtern')->findAll();
        
        foreach ($vereine as $vereinExtern) {
            $vereinBridge = $this->emDefault->getRepository('AppBundle\EntityExtern\VereinExtern')->find($vereinExtern->getId());
            if ($vereinBridge == null) {
                $this->emDefault->persist($vereinExtern);
            } else {
                
            }
            
        }
        $this->emDefault->flush();
    }
    
    private static function sync($vereinExtern, $vereinBridge){
        
    }
}
