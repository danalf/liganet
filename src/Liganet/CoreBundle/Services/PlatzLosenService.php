<?php

namespace Liganet\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Liganet\CoreBundle\Entity;

/**
 * Klasse zum Losen einer Ligasaison
 * @package ligaweb
 * @author Jörg Alfredo Henschel
 * @version 1.0
 * @copyright Rhein-Neckar-Liga
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 */
class PlatzLosenService {

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
    private $teams;
    private $anzahlTeams = 0;
    private $anzahlBegegnungenProRunde = 0;
    private $anzahlBenoetigtePlaetze = 0;
    private $anzahlSpieleHintereinander = 0;
    private $plaetze = array();

    const ANZAHL_VERSUCHE = 15000;

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

    function losen() {
        $this->deleteOld();
        
        $this->teams = $this->ligaSaison->getMannschaften();
        $this->anzahlTeams = $this->teams->count();
        $this->anzahlBegegnungenProRunde = floor($this->anzahlTeams / 2);
        $this->berechnePlaetze();
            $this->writeDb();
            echo "<p>Ergebnis wurde in die Datenbank geschrieben</p>";

    }

    /**
     * Loescht die alten Datensätze zur Losung, damit sie neu geschrieben werden koennen
     */
    private function deleteOld() {
        $this->em->beginTransaction();
        foreach ($this->ligaSaison->getSpieltage() as $spieltag) {
            foreach ($spieltag->getRunden() as $runde) {
                foreach ($runde->getBegegnungen() as $begegnung) {
                    $ergebnisse=$begegnung->getErgebnisse();
                    if(isset($ergebnisse)){
                        foreach ($ergebnisse as $ergebnis) {
                        $this->em->remove($ergebnis);
                        $this->em->flush();
                        }
                    }
                    
                }
            }
        }
        $this->em->commit();
    }


    private function writeDb() {
        
        $spielrunden =  $this->em->getRepository('LiganetCoreBundle:SpielRunde')->findByLigaSaisonOrdered($this->ligaSaison);
        
        
        foreach ($spielrunden as $spielrunde) {
            $this->fillPlatzArray($spielrunde->getNummer());
            var_dump($this->plaetze);
            foreach ($spielrunde->getBegegnungen() as $begegnung) {
                //Begegnungen in Ergebnistabelle incl. Platz eintragen
                $spielart = $this->em->getRepository('LiganetCoreBundle:SpielArt')->findBy(array('modus' => $this->ligaSaison->getLiga()->getModus()->getId()), array('nummer' => 'ASC'));
                foreach ($spielart as $spiel) {
                    $reihenfolge = $spiel->getReihenfolge();
                    $platz = array_pop($this->plaetze[$reihenfolge - 1]);
                    $ergebnis = new Entity\Ergebnis;
                    $ergebnis->setPlatz($platz);
                    $ergebnis->setBegegnung($begegnung);
                    $ergebnis->setSpielArt($spiel);
                    $this->em->persist($ergebnis);
                    $this->em->flush();
                }
            }
        }
    }



    /**
     *
     * @param array $array Array der Teams als Referenz
     * @return bool Erfolg
     */
    private function shuffle_assoc(&$array) {
        $new=array();
        $keys = array_keys($array);
        shuffle($keys);
        $i = 0;
        foreach ($keys as $key) {
            $new[$i] = $array[$key];
            $i++;
        }
        $array = $new;
        return true;
    }

    private function berechnePlaetze() {
        //Maximale Anzahl der Plätze berechnen
        $maxAnzahlSpieleGleichzeitig = $this->ligaSaison->getLiga()->getModus()->getMaxAnzahlSpieleGleichzeitig();
        $this->anzahlBenoetigtePlaetze = $maxAnzahlSpieleGleichzeitig * $this->anzahlBegegnungenProRunde;
        $this->anzahlSpieleHintereinander = $this->ligaSaison->getLiga()->getModus()->getAnzahlSpieleHintereinander();
        echo $this->anzahlSpieleHintereinander." ".$this->anzahlBenoetigtePlaetze."<br />";
    }

    /**
     * Array für Plätze mit Spiele hintereinander füllen
     */
    private function fillPlatzArray($runde) {
        unset($this->plaetze);
        $this->plaetze = array();
        switch ($this->ligaSaison->getLiga()->getModus()->getId()) {
            case 5:
                $test = 0;
                for ($index = 0; $index < $this->anzahlSpieleHintereinander; $index++) {
                    $platzArray = array();
                    for ($indexPlatz = 1; $indexPlatz <= $this->anzahlBenoetigtePlaetze; $indexPlatz++) {
                        //Workaround für Plätze bei Doubletten
                        if ($index == 0 and ( $indexPlatz + 1) % 3 == 0)
                            $indexPlatz++;
                        array_push($platzArray, $indexPlatz);
                    }
                    //Array Runde für Runde verschieben
                    //Verschiebung in Abhängigkeit der SPiele gleichzeitig
                    switch ($index) {
                        case 0:
                            $plaetzeGleichzeitig = 2;
                            break;
                        default:
                            $plaetzeGleichzeitig = 3;
                            break;
                    }


                    $platzArray = array_reverse($platzArray);
                    $this->verschiebePlatzArray($platzArray, $runde, $index + 1);
                    array_push($this->plaetze, $platzArray);
                }
                break;

            default:
                for ($index = 0; $index < $this->anzahlSpieleHintereinander; $index++) {
                    $platzArray = array();
                    for ($indexPlatz = 1; $indexPlatz <= $this->anzahlBenoetigtePlaetze; $indexPlatz++) {
                        array_push($platzArray, $indexPlatz);
                    }
                    $this->shuffle_assoc($platzArray);
                    array_push($this->plaetze, $platzArray);
                }
                break;
        }
    }

    /**
     *
     * @param array $array Array der Teams als Referenz
     * @return bool Erfolg
     */
    private function verschiebePlatzArray(&$array, $runde, $spieleGleichzeitig) {
        for ($indexRunde=1;$indexRunde<$runde;$indexRunde++) {
            for ($indexSpiele = 0; $indexSpiele <= $spieleGleichzeitig; $indexSpiele++) {
                $temp = array_shift($array);
                array_push($array, $temp);
            }
        }

        return true;
    }
    
    

}

?>
