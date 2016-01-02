<?php

namespace AppBundle\Util;

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
class LosenService {

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

    /**
     *
     * @var array Die Teams
     */
    private $teams;
    private $vereine = array();
    private $anzahlRunden = 0;
    private $runden = array();
    private $begegnungen = array();
    private $anzahlTeams = 0;
    private $anzahlBegegnungenProRunde = 0;
    private $anzahlBegegnungenProTeam = 0;
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
        $this->readDb();

        for ($index = 0; $index < self::ANZAHL_VERSUCHE; $index++) {
            //echo "<br />Versuch Nr" . ($index + 1) . "";
            unset($this->begegnungen);
            $this->begegnungen = array();
            $this->resetInterneDuelle();
            $this->setRunden();
            $this->anzahlTeams = $this->teams->count();
            $this->anzahlBegegnungenProRunde = floor($this->anzahlTeams / 2);
            $this->setGegnerArrays();
            $this->setRundenArray();
            $this->losung();
            if ($this->checkLosung()) {
                $this->checkPosition();
                $success = true;
                break;
            }
        }
        //$this->checkPosition();
        $this->berechnePlaetze();
        if (!isset($success)) {
            echo "<p>Losung nach " . self::ANZAHL_VERSUCHE . " Versuchen fehlgeschlagen</p>";
        } else {
            echo "<p>Losung nach " . ($index + 1) . " von " . self::ANZAHL_VERSUCHE . " möglichen Versuchen erfolgreich. 
                    Alte Losung gelöscht und die neue in die Datenbank geschrieben. Ergebnistabelle incl. Platzlosung ergänzt.</p>";
            echo "<ul>
                    <li>Teams: " . $this->countTeams() . "</li>
                    <li>Runden: " . $this->anzahlRunden . "</li>
                    <li>Begegnungen pro Runde: " . $this->anzahlBegegnungenProRunde . "</li>
                    <li>Anzahl benötigter Plätze: " . $this->anzahlBenoetigtePlaetze . "</li>
                  </ul>";
            $this->showErgebnis();
            $this->writeDb();
            echo "<p>Ergebnis wurde in die Datenbank geschrieben</p>";
        }
    }

    /**
     * Loescht die alten Datensätze zur Losung, damit sie neu geschrieben werden koennen
     */
    private function deleteOld() {
        $this->em->beginTransaction();
        foreach ($this->ligaSaison->getSpieltage() as $spieltag) {
            foreach ($spieltag->getRunden() as $runde) {
                foreach ($runde->getBegegnungen() as $begegnung) {
                    $this->em->remove($begegnung);
                    $this->em->flush();
                }
                foreach ($runde->getTabelle() as $tabelle) {
                    $this->em->remove($tabelle);
                    $this->em->flush();
                }
            }
        }
        $this->em->commit();
    }

    /**
     * Liest die Daten aus der Datenbank und packt sie in ein Array aus entprechenden Objekten
     */
    private function readDb() {
        $this->teams = $this->ligaSaison->getMannschaften();
        //teilnehmende Vereine aus der Liga incl Anzahl der internen Duelle
        $query = $this->em->createQuery(
                'SELECT v.id, count(m.id) AS anzahlInterneGegner
                    FROM LiganetCoreBundle:Verein v 
                    JOIN v.mannschaften m
                    WHERE m.ligasaison=' . $this->ligaSaison->getId() . ' 
                    GROUP BY v.id');
        $vereine = $query->getResult();
        //echo "<pre>";
        //print_r($vereine);
        //return true;
        //Einzelne Vereins-ID durchgehen und Stück für Stück in ein Array packen
        foreach ($vereine as $verein) {
            $entity = $this->em->getRepository('LiganetCoreBundle:Verein')->find($verein["id"]);
            //$entity->setAnzahlInterneDuelle($verein["anzahlInterneGegner"]);
            //n*(n-1)/k
            $entity->setAnzahlInterneDuelle($verein["anzahlInterneGegner"]*($verein["anzahlInterneGegner"]-1)/2);
            array_push($this->vereine, $entity);
        }
        return TRUE;
    }

    /**
     * Chekct, ob alle Teams gleich oft an erster Stelle stehen, falls nicht, wird das korrigiert 
     */
    private function checkPosition() {
        $teams = array();
        //Array mit allen Teams anlegen
        foreach ($this->teams as $value) {
            $teams[$value->getId()] = 0;
        }
        foreach ($this->begegnungen as $runde) {
            foreach ($runde as $begegnung) {
                $teams[$begegnung[0]->getId()]+=1;
            }
        }
        arsort($teams);
        $min = end($teams);
        asort($teams);
        $max = end($teams);
        echo "Abstand: " . ($max - $min) . " ";
        if ($max - $min > 1) {
            $teams = array_keys($teams);
            for ($index = 0; $index < count($teams); $index++) {
                if ($this->swapTeams($teams[$index], end($teams))) {
                    break;
                }
            }
            $this->checkPosition();
        } else {
            return true;
        }
        return false;
    }

    /**
     * Vertauscht 2 Teams in einer Begegnung
     * @param type $team1
     * @param type $team2 
     */
    private function swapTeams($team1, $team2) {
        for ($indexRunden = 0; $indexRunden < $this->anzahlRunden; $indexRunden++) {
            for ($indexBegegnung = 0; $indexBegegnung < count($this->begegnungen[$indexRunden]); $indexBegegnung++) {
                $ta = $this->begegnungen[$indexRunden][$indexBegegnung][0]->getId();
                $tb = $this->begegnungen[$indexRunden][$indexBegegnung][1]->getId();
                if ($ta == $team2 && $tb == $team1) {
                    $this->begegnungen[$indexRunden][$indexBegegnung][2] = $this->begegnungen[$indexRunden][$indexBegegnung][0];
                    $this->begegnungen[$indexRunden][$indexBegegnung][0] = $this->begegnungen[$indexRunden][$indexBegegnung][1];
                    $this->begegnungen[$indexRunden][$indexBegegnung][1] = $this->begegnungen[$indexRunden][$indexBegegnung][2];
                    unset($this->begegnungen[$indexRunden][$indexBegegnung][2]);
                    return TRUE;
                }
            }
        }
        echo "FALSE";
        return FALSE;
    }

    private function writeDb() {
        $fehler = FALSE;

        $query = $this->em->createQuery(
                "SELECT sr FROM LiganetCoreBundle:SpielRunde sr 
                    JOIN sr.spieltag t
                    WHERE t.ligasaison=" . $this->ligaSaison->getId() . " 
                    ORDER BY sr.nummer");
        $spielrunden = $query->getArrayResult();

        for ($indexRunden = 0; $indexRunden < $this->anzahlRunden; $indexRunden++) {

            if (!isset($spielrunden[$indexRunden]['id'])) {
                $fehler = true;
                echo "Nicht alle Runden eingetragen";
            };
            $spielrunde = $this->em->getRepository('LiganetCoreBundle:SpielRunde')->find($spielrunden[$indexRunden]['id']);
            $runde = $this->begegnungen[$indexRunden];
            $this->fillPlatzArray($indexRunden + 1);
            foreach ($runde as $begegnung) {
                //Begegnung speichern
                $begegnung_obj = new Entity\Begegnung;
                $begegnung_obj->setMannschaft1($begegnung[0]);
                $begegnung_obj->setMannschaft2($begegnung[1]);
                $begegnung_obj->setSpielRunde($spielrunde);
                $this->em->persist($begegnung_obj);
                $this->em->flush();

                //Begegnungen in Ergebnistabelle incl. Platz eintragen
                $spiel = new Entity\SpielArt;
                $spielart = $this->em->getRepository('LiganetCoreBundle:SpielArt')->findBy(array('modus' => $this->ligaSaison->getLiga()->getModus()->getId()), array('nummer' => 'ASC'));
                foreach ($spielart as $spiel) {
                    $reihenfolge = $spiel->getReihenfolge();
                    $platz = array_pop($this->plaetze[$reihenfolge - 1]);
                    $ergebnis = new Entity\Ergebnis;
                    $ergebnis->setPlatz($platz);
                    $ergebnis->setBegegnung($begegnung_obj);
                    $ergebnis->setSpielArt($spiel);
                    $this->em->persist($ergebnis);
                    $this->em->flush();
                }
            }
            //Tabelle füllen
            foreach ($this->ligaSaison->getMannschaften() as $mannschaft) {
                $tabelle = new Entity\Tabelle;
                $tabelle->setSpielrunde($spielrunde);
                $tabelle->setMannschaft($mannschaft);
                $this->em->persist($tabelle);
                $this->em->flush();
            }
        }

        if ($fehler) {
            echo "<p>FEHLER BEIM SCHREIBEN IN DIE DATENBANK. Alle Runden eingetragen? ($fehler)</p>";
        }
    }

    /**
     * zum Debuggen 
     */
    private function showErgebnis() {
        echo "<h1>Ergebnis</h1>";
        for ($indexRunden = 0; $indexRunden < $this->anzahlRunden; $indexRunden++) {
            $runde = $this->begegnungen[$indexRunden];
            echo "<h2>Runde" . ($indexRunden + 1) . "</h2>";
            foreach ($runde as $begegnung) {

                echo $begegnung[0] . " - " . $begegnung[1] . "<br />";
            }
        }
    }

    private function setGegnerArrays() {
        foreach ($this->teams as $team) {
            unset($team->gegner);
            $team->gegner = array();
            $gegner = array();
            foreach ($this->teams as $value) {
                if ($team <> $value) {
                    array_push($gegner, $value);
                }
            }
            $this->shuffle_assoc($gegner);
            $team->gegner = $gegner;
        }
    }

    private function setRundenArray() {
        unset($this->runden);
        $this->runden = array();
        //Schleife über die Runden
        for ($index = 0; $index < $this->anzahlRunden; $index++) {
            $teamsRunde = $this->teams;
            $teamsRunde = array();
            foreach ($this->teams as $team) {
                array_push($teamsRunde, $team);
            }
            $this->shuffle_assoc($teamsRunde);
            array_push($this->runden, $teamsRunde);
        }
    }

    private function checkLosung() {
        //echo " - Anzahl Begegnungen pro Runde:";
        foreach ($this->begegnungen as $runde) {
            //echo "-" . count($runde). "-";
            if (count($runde) < $this->anzahlBegegnungenProRunde)
                return FALSE;
        }
        //echo "<br />Anzahl Begegnungen pro Team:";
        foreach ($this->teams as $team) {
            //echo "-" . $team->anzahlBegegnungenGelost . "-";
            if ($team->anzahlBegegnungenGelost < ($this->anzahlTeams) - 1)
                return FALSE;
        }
        return TRUE;
    }

    private function losung() {
        //Schleife über die Runden
        for ($indexRunden = 0; $indexRunden < $this->anzahlRunden; $indexRunden++) {
            $runde = array();
            $team = new Entity\Mannschaft;
            $mannschaftsArray = $this->runden[$indexRunden];
            //Platznummer für alle auf 0 setzen
            $platz = 0;
            //Schleife über Teams für das interne Duell
            //Schleife über die Mannschaften der Runde
            for ($indexTeams = 0; $indexTeams < $this->anzahlTeams; $indexTeams++) {
                if (!isset($mannschaftsArray[$indexTeams]))
                    continue;
                $team = $mannschaftsArray[$indexTeams];
                if ($team->getNrRundeGespielt() == $indexRunden)
                    continue;
                if ($team->getVerein()->isInternesDuell()) {
                    //Schleife über die verbleibenden Gegner des Teams
                    $gegnerArray = $team->gegner;
                    for ($indexGegner = 0; $indexGegner < $this->anzahlTeams; $indexGegner++) {
                        if (!isset($gegnerArray[$indexGegner]))
                            continue;
                        //$gegner = new Entity\Mannschaft;
                        $gegner = $gegnerArray[$indexGegner];
                        if ($gegner->getNrRundeGespielt() == $indexRunden)
                            continue;
                        $verein = $team->getVerein();
                        if ($team->getVerein()->getId() == $gegner->getVerein()->getId()) {
                            $begegnung = array($team, $gegner);
                            array_push($runde, $begegnung);
                            //Gegner aus der Generliste herausnehmen
                            $this->removeFromArray($team->gegner, $gegner);
                            $this->removeFromArray($gegner->gegner, $team);
                            $team->setNrRundeGespielt($indexRunden);
                            $gegner->setNrRundeGespielt($indexRunden);
                            $team->anzahlBegegnungenGelost +=1;
                            $gegner->anzahlBegegnungenGelost +=1;
                            break;
                        }
                    }
                    $team->getVerein()->increaseAnzahlInterneDuelleGespielt();
                }
            }
            //Schleife über die Mannschaften der Runde (kein internes Duell
            for ($indexTeams = 0; $indexTeams < $this->anzahlTeams; $indexTeams++) {
                if (!isset($mannschaftsArray[$indexTeams]))
                    continue;
                $team = $mannschaftsArray[$indexTeams];
                if ($team->getNrRundeGespielt() == $indexRunden)
                    continue;
                //Schleife über die verbleibenden Gegner des Teams
                $gegnerArray = $team->gegner;
                for ($indexGegner = 0; $indexGegner < $this->anzahlTeams; $indexGegner++) {
                    if (!isset($gegnerArray[$indexGegner]))
                        continue;
                    $gegner = $gegnerArray[$indexGegner];
                    if ($gegner->getNrRundeGespielt() == $indexRunden)
                        continue;
                    $verein = $team->getVerein();
                    $begegnung = array($team, $gegner, $platz);
                    array_push($runde, $begegnung);
                    //Gegner aus der Gegnerliste herausnehmen
                    $this->removeFromArray($team->gegner, $gegner);
                    $this->removeFromArray($gegner->gegner, $team);
                    //Teams aus den noch zu losenden Teams der Runde nehmen
                    $team->setNrRundeGespielt($indexRunden);
                    $gegner->setNrRundeGespielt($indexRunden);
                    $team->anzahlBegegnungenGelost +=1;
                    $gegner->anzahlBegegnungenGelost +=1;
                    break;
                }
            }
            array_push($this->begegnungen, $runde);
        }
    }

    private function removeFromArray(&$array, $team) {
        for ($index = 0; $index < $this->anzahlTeams; $index++) {
            if (!isset($array[$index]))
                continue;
            if ($array[$index] == $team) {
                unset($array[$index]);
                return;
            }
        }
    }

    /**
     * 
     */
    private function resetInterneDuelle() {
        $verein = new Entity\Verein;
        foreach ($this->vereine as $verein) {
            $verein->setAnzahlInterneDuelleGespielt(0);
        }
    }

    /**
     *
     * @return int Anzahl der Teams 
     */
    private function countTeams() {
        return count($this->teams);
    }

    /**
     * Gibt die Anzahl der zu spielenden Runden aus
     * 
     * falls der Wert 0 ist, wird die Anzahl anhand der Teamanzahl ausgerechnet
     * @return int Anzahl der zu spielenden Runden 
     */
    private function setRunden() {
        if ($this->anzahlRunden == 0) {
            switch ($this->ligaSaison->getLiga()->getModus()->getModusRunden()->getId()) {
                //Jeder gegen jeden
                case 1:
                    $this->anzahlRunden = (ceil($this->countTeams() / 2) * 2) - 1;
                    $this->anzahlBegegnungenProTeam = $this->countTeams() - 1;
                    break;
                //Hin- und Rückrunde
                case 2:
                    $this->anzahlRunden = ((ceil($this->countTeams() / 2) * 2) - 1) * 2;
                    $this->anzahlBegegnungenProTeam = ($this->countTeams() - 1) * 2;
                    break;
                //feste Anzahl
                case 3:
                    $this->anzahlRunden = $this->modus->getAnzahlRunden();
                    $this->anzahlBegegnungenProTeam = $this->modus->getAnzahlRunden();
            }
        }
        return $this->anzahlRunden;
    }

    /**
     *
     * @param array $array Array der Teams als Referenz
     * @return bool Erfolg
     */
    private function shuffle_assoc(&$array) {
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
