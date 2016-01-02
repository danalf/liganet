<?php

namespace AppBundle\Util;

use Doctrine\ORM\EntityManager;
use Liganet\CoreBundle\Entity;

/**
 * Description of class
 *
 * long desc
 * @package ligaweb
 * @author Jörg Alfredo Henschel
 * @version 1.0
 * @copyright Rhein-Neckar-Liga
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 */
class berechnenErgebnisService {

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    /**
     *
     * @var Entity\LigaSaison 
     */
    private $ligaSaison;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function setLigaSaison(Entity\LigaSaison $ligasaison) {
        $this->ligaSaison = $ligasaison;
        if ($this->ligaSaison->getGesperrt()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function makeTabellen() {

        $mannschaften = $this->ligaSaison->getMannschaften();

        $spielrunden = $this->em->getRepository('LiganetCoreBundle:SpielRunde')->findByLigaSaisonOrdered($this->ligaSaison);

        foreach ($spielrunden as $runde) {
            /* @var $runde SpielRunde  */
            
            $begegnungen = $this->em->getRepository('LiganetCoreBundle:Begegnung')->findBegegnungenUntil($runde);
            //Tabellenelememente mit allen bis zur Spielrunde stattgefundenen Begegnungen füllen
            foreach ($runde->getTabelle() as $tab) {
                 /* @var $tab Entity\Tabelle */
                $tab->reset();
                foreach ($begegnungen as $begegnung) {
                    /* @var $begegnung Begegnung  */
                    $begegnung->addToTable($tab);      
                }
            }
            //Tabelle sortieren
            $this->berechnenRang($runde->getTabelle()->toArray());
            //Tabelle in die DB schreiben
            foreach ($runde->getTabelle() as $tab) {
                $this->em->persist($tab);
                $this->em->flush();
            }
        }
    }
    
    
    public function makeTabellenOld() {

        $mannschaften = $this->ligaSaison->getMannschaften();
        //Tabellenarray erzeugen

        foreach ($mannschaften as $mannschaft) {
            /* @var $mannschaft Mannschaft */
            $tab = new Entity\Tabelle();
            $tab->setMannschaft($mannschaft);
            $tab->reset();
            $arrayTabelle[] = $tab;
        }
        $spielrunden = $this->em->getRepository('LiganetCoreBundle:SpielRunde')->findByLigaSaisonOrdered($this->ligaSaison);

        foreach ($spielrunden as $runde) {
            /* @var $runde SpielRunde  */
            $begegnungen = $this->em->getRepository('LiganetCoreBundle:Begegnung')->findBegegnungenUntil($runde);
            foreach ($arrayTabelle as $tab) {
                /* @var $tab Entity\Tabelle */
                $tab->reset();
                $tab->setSpielrunde($runde);
            }
            //Tabellenelememente mit allen bis zur Spielrunde stattgefundenen Begegnungen füllen
            foreach ($arrayTabelle as $tab) {
                foreach ($begegnungen as $begegnung) {
                    /* @var $begegnung Begegnung  */
                    $begegnung->addToTable($tab);
                    
                }
            }
            //Tabelle sortieren
            $this->berechnenRang($runde->getTabelle());
            //Tabelle in die DB schreiben
            foreach ($arrayTabelle as $tab) {
                $this->em->persist($tab);
                $this->em->flush();
            }
        }
    }

    private function berechnenRang($tabellenArray) {
        usort($tabellenArray, "Liganet\CoreBundle\Entity\Tabelle::compare");
        $rang = 1;
        foreach ($tabellenArray as $current) {
            if (isset($nextBest) and Entity\Tabelle::compare($current, $nextBest) == 0) {
                $current->setRang($nextBest->getRang());
            } else {
                $current->setRang($rang);
            }
            $rang++;
            $nextBest = $current;
        }
    }

}

