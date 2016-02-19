<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Util;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\VereinExtern;
use AppBundle\Entity\Verein;

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
        $vereine = $this->emExtern->getRepository('AppBundle\Entity\VereinExtern')->findAll();

        foreach ($vereine as $vereinExtern) {
            $vereinBridge = $this->emDefault->getRepository('AppBundle\Entity\VereinExtern')->find($vereinExtern->getId());
            if ($vereinBridge == null) {
                $this->emDefault->persist($vereinExtern);
            } else {
                $this->sync($vereinExtern, $vereinBridge);
            }
            
        }
        $this->emDefault->flush();
    }
    
    private function sync(VereinExtern $vereinExtern, VereinExtern $vereinBridge){
        $vereinBridge->setASPMobil($vereinExtern->getASPMobil());
        $vereinBridge->setASPName($vereinExtern->getASPName());
        $vereinBridge->setASPOrt($vereinExtern->getASPOrt());
        $vereinBridge->setASPPLZ($vereinExtern->getASPPLZ());
        $vereinBridge->setASPStrasse($vereinExtern->getASPStrasse());
        $vereinBridge->setASPTel($vereinExtern->getASPTel());
        $vereinBridge->setAktiv($vereinExtern->getAktiv());
        $vereinBridge->setBezirk($vereinExtern->getBezirk());
        $vereinBridge->setEmailVerein($vereinExtern->getEmailVerein());
        $vereinBridge->setLigaKuerzel($vereinExtern->getLigaKuerzel());
        $vereinBridge->setLigaName($vereinExtern->getLigaName());
        $vereinBridge->getLigaVAEmail($vereinExtern->getLigaVAEmail());
        $vereinBridge->setLigaVAName($vereinExtern->getLigaVAName());
        $vereinBridge->setLigaVAOrt($vereinExtern->getLigaVAOrt());
        $vereinBridge->setLigaVAPlz($vereinExtern->getLigaVAPlz());
        $vereinBridge->setLigaVAStrasse($vereinExtern->getLigaVAStrasse());
        $vereinBridge->setLigaVATel($vereinExtern->getLigaVATel());
        $vereinBridge->setLigabezirkID($vereinExtern->getLigabezirkID());
        $vereinBridge->setName($vereinExtern->getName());
        $vereinBridge->setOrt($vereinExtern->getOrt());
        $vereinBridge->setPlz($vereinExtern->getPlz());
        $vereinBridge->setStrasse($vereinExtern->getStrasse());
        $vereinBridge->setTelVerein($vereinExtern->getTelVerein());
        $vereinBridge->setZusatz($vereinExtern->getZusatz());
        $this->emDefault->persist($vereinBridge);
    }
    
    public function setNewDatasets(VereinExtern $vereinExtern, Verein $verein=null){
        if (!$verein){
            $verein = new Verein();
        }
        $verein->setName($vereinExtern->getName() . " " .$vereinExtern->getZusatz());
        $verein->setNamekurz($vereinExtern->getName());
        $nummer = explode('-', $vereinExtern->getId());
        $verein->setNummer((int)$nummer[1]);
        $verein->setVereinExtern($vereinExtern);
        $region = $this->emDefault->getRepository('AppBundle\Entity\Region')->findOneBy(['ligabezirkID' => $vereinExtern->getLigaBezirkID()] );
        if (!$region){
            throw new Exception("Region nicht über ligaBezirkId gefunden");
        }
        $verein->setRegion($region);
        $verein->setKuerzel($vereinExtern->getLigaKuerzel());
        $verein->setUpdatedAt(new \DateTime());
        $this->emDefault->persist($verein);
    }
}
