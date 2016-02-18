<?php

namespace AppBundle\Util;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\SpielerExtern;
use AppBundle\Entity\Spieler;

/**
 * SpielerSync
 *
 * @author alfredo
 */
class SpielerSync
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
        $spieler = $this->doctrine
            ->getRepository('AppBundle\Entity\SpielerExtern', 'extern')
            ->findAll();
        foreach ($spieler as $spielerExtern) {
            if ($spielerExtern->getId() == null){
                continue;
            }
            $spielerBridge = $this->emDefault->getRepository('AppBundle\Entity\SpielerExtern')->find($spielerExtern->getId());
            if ($spielerBridge == null) {
                $this->emDefault->persist($spielerExtern);
            } else {
                $this->sync($spielerExtern, $spielerBridge);
            }
            
        }
        $this->emDefault->flush();
    }
    
    private function sync(SpielerExtern $spielerExtern, SpielerExtern $spielerBridge){
        $spielerBridge->setBezirk($spielerExtern->getBezirk());
        $spielerBridge->setEmail($spielerExtern->getEmail());
        $spielerBridge->setGebDatum($spielerExtern->getGebDatum());
        $spielerBridge->setGeschlecht($spielerExtern->getGeschlecht());
        $spielerBridge->setLigaBezirkID($spielerExtern->getLigaBezirkID());
        $spielerBridge->setLizenzJahr($spielerExtern->getLizenzJahr());
        $spielerBridge->setLizenznummer($spielerExtern->getLizenznummer());
        $spielerBridge->setNachname($spielerExtern->getNachname());
        $spielerBridge->setNationalitaet($spielerExtern->getNationalitaet());
        $spielerBridge->setOrt($spielerExtern->getOrt());
        $spielerBridge->setPlz($spielerExtern->getPlz());
        $spielerBridge->setStrasse($spielerExtern->getStrasse());
        $spielerBridge->setTelefon($spielerExtern->getTelefon());
        $spielerBridge->setVerein($spielerExtern->getVerein());
        $spielerBridge->setVorname($spielerExtern->getVorname());
        
        $this->emDefault->persist($spielerBridge);
    }
    
    public function setNewDatasets(SpielerExtern $spielerExtern){
        $spieler = new Spieler();
        $spieler->setSpielerExtern($spielerExtern);
        $spieler->setVorname($spielerExtern->getVorname());
        $spieler->setNachname($spielerExtern->getNachname());
        $nummer = explode('-', $spielerExtern->getLizenznummer());
        $spieler->setNummerlizenz($nummer[2]);
        $verein = $this->emDefault->getRepository('AppBundle\Entity\Verein')->findOneByLizenznummer($spielerExtern->getLizenznummer());
        $spieler->setVerein($verein);
        $spieler->setVeraendertam(new \DateTime);
        $anrede = $this->emDefault->getRepository('AppBundle\Entity\Anrede')->findOneBy(['geschlecht' => $spielerExtern->getGeschlecht()]);
        $spieler->setAnrede($anrede);
        $spieler->setBestaetigt(true);
        $this->emDefault->persist($spieler);
    }
}
