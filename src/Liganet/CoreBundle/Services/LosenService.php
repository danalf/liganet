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

    /**
     * Variable zur für den Modus
     *
     * Damit wird gesteuert, ob es nur Hin- oder auch Rückrunde gibt
     * @var Modus
     */
    private $modus;
    private $spielArt;
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
            $this->anzahlTeams = $this->countTeams();
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
            //$this->showErgebnis();
            $this->writeDb();
            echo "<p>Ergebnis wurde in die Datenbank geschrieben</p>";
        }
    }

    private function deleteOld() {
        $this->em->createQueryBuilder()
            ->delete('Begegnung b')
            ->where('b.id IN (SELECT b.id FROM TableB b INNER JOIN b.TableA a WHERE b.date > NOW() AND a.channel_id = 10)')
            ->getQuery()
            ->execute();
        
        
        
        $sql = "CREATE TABLE temp SELECT idtblErgebnis
                FROM  `viewErgebnis`
                WHERE saison =$this->saison
                AND idtblLiga =$this->idtblLiga";
        $result = $GLOBALS['DB']->exec($sql);
        $sql = "DELETE FROM tblErgebnis WHERE idtblErgebnis IN ( SELECT idtblErgebnis FROM temp)";
        $result = $GLOBALS['DB']->exec($sql);
        $sql = "DROP TABLE temp";
        $result = $GLOBALS['DB']->exec($sql);
        $sql = "SELECT * FROM viewBegegnung WHERE saison=$this->saison AND idtblLiga=$this->idtblLiga";
        $result = $GLOBALS['DB']->query($sql);
        $begegnungen = new Begegnung();
        $begegnungen = $result->fetchALL(PDO::FETCH_CLASS, "Begegnung");
        foreach ($begegnungen as $begegnung) {
            $sql = "DELETE FROM tblBegegnung WHERE idtblBegegnung=" . $begegnung->getId();
            $result = $GLOBALS['DB']->query($sql);
        }
        $sql = "CREATE TABLE temp SELECT idtblSpielRunde
                FROM  `viewSpielrunde`
                WHERE saison =$this->saison
                AND idtblLiga =$this->idtblLiga
                GROUP BY idtblSpielRunde";
        $result = $GLOBALS['DB']->exec($sql);
        $sql = "DELETE FROM tblTabelle WHERE idtblSpielRunde IN ( SELECT idtblSpielRunde FROM temp)";
        $result = $GLOBALS['DB']->exec($sql);
        $sql = "DROP TABLE temp";
        $result = $GLOBALS['DB']->exec($sql);
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
        $sql = "SELECT * FROM viewSpielrunde WHERE saison=$this->saison AND idtblLiga=$this->idtblLiga ORDER BY nummer";
        $result = $GLOBALS['DB']->query($sql);
        $spielrunden = $result->fetchALL(PDO::FETCH_CLASS, "SpielRunde");
        $fehler = FALSE;
        for ($indexRunden = 0; $indexRunden < $this->anzahlRunden; $indexRunden++) {
            $spielrunde = $spielrunden[$indexRunden];
            $runde = $this->begegnungen[$indexRunden];
            $this->fillPlatzArray();
            foreach ($runde as $begegnung) {
                $sql = "INSERT INTO tblBegegnung(idtblSpielRunde, mannschaft1, mannschaft2) VALUES ("
                        . $spielrunde->getId() . "," . $begegnung[0]->getId() . "," . $begegnung[1]->getId() . " )";
                $count = $GLOBALS['DB']->exec($sql);
                if ($count <> 1) {
                    $fehler = $sql;
                }

                //gerade eingefügte idtblBegegnung ermitteln
                $sql = "SELECT * FROM tblBegegnung WHERE idtblSpielrunde=" . $spielrunde->getId()
                        . " AND mannschaft1=" . $begegnung[0]->getId()
                        . " AND mannschaft2=" . $begegnung[1]->getId();
                $result = $GLOBALS['DB']->query($sql);
                $begegnung = new Begegnung();
                foreach ($GLOBALS['DB']->query($sql) as $row) {
                    $begegnungId = $row['idtblBegegnung'];
                }
                //Begegnungen in Ergebnistabelle incl. Platz eintragen
                $spiel = new SpielArt();
                foreach ($this->spielArt as $spiel) {
                    $reihenfolge = $spiel->getReihenfolge();
                    $platz = array_pop($this->plaetze[$reihenfolge - 1]);
                    $sql = "INSERT INTO tblErgebnis(idtblBegegnung, idtblSpielArt, platz) VALUES ("
                            . $begegnungId . ", " . $spiel->getId() . ", " . $platz . ")";
                    $count = $GLOBALS['DB']->exec($sql);
                    if ($count <> 1)
                        $fehler = $sql;
                }
            }
        }
        //Tabelle füllen
        $this->fillTabelle();
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
                echo $begegnung[0]->getName() . " - " . $begegnung[1]->getName() . "<br />";
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
            $team = new Mannschaft();
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
                        $gegner = new Mannschaft();
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
     * Liest die Daten aus der Datenbank und packt sie in ein Array aus entprechenden Objekten
     */
    private function readDb() {

        //teilnehmende Vereine aus der Liga incl Anzahl der internen Duelle
        $sql = "SELECT idtblLiga, m.idtblVerein, saison, COUNT( m.idtblVerein ) -1 AS anzahlInterneGegner " .
                "FROM  `viewMannschaft` m JOIN tblVerein v ON v.idtblVerein = m.idtblVerein " .
                "WHERE idtblLiga =$this->idtblLiga AND saison =$this->saison GROUP BY idtblVerein";
        $result = $GLOBALS['DB']->query($sql);
        //Einzelne Vereins-ID durchgehen und Stück für Stück in ein Array packen
        foreach ($result as $value) {
            $sql = "SELECT * FROM viewVerein WHERE idtblVerein=" . $value["idtblVerein"];
            $resultVerein = $GLOBALS['DB']->query($sql);
            $verein = new Verein();
            $verein = $resultVerein->fetchALL(PDO::FETCH_CLASS, "Verein");
            $verein[0]->setAnzahlInterneDuelle($value["anzahlInterneGegner"]);
            array_push($this->vereine, $verein[0]);
        }
        //Mannschaften das Vereinsobjekt zuweisen
        foreach ($this->vereine as $verein) {
            foreach ($this->teams as $team) {
                if ($verein->getId() == $team->getIdtblVerein()) {
                    $team->setVerein($verein);
                }
            }
        }
    }

    /**
     * 
     */
    private function resetInterneDuelle() {
        $verein = new Verein();
        foreach ($this->vereine as $verein) {
            $verein->resetAnzahlInterneDuelleGespielt();
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
            switch ($this->modus->getIdtblModusRunden()) {
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
        $sql = "SELECT MAX( anzahl ) AS maxAnzahl FROM (
            SELECT COUNT( reihenfolge ) AS anzahl
            FROM tblSpielArt
            WHERE idtblModus = " . $this->modus->getId() . "
            GROUP BY reihenfolge
            ) AS tblSpielArt;";
        $maxAnzahlSpieleGleichzeitig = 0;
        //Sollte nur einmal durchlaufen
        foreach ($GLOBALS['DB']->query($sql) as $row) {
            $maxAnzahlSpieleGleichzeitig = $row['maxAnzahl'];
        }
        $this->anzahlBenoetigtePlaetze = $maxAnzahlSpieleGleichzeitig * $this->anzahlBegegnungenProRunde;
        //Anzahl der Spiele hintereinander pro Begegnung
        $sql = "SELECT COUNT( reihenfolge ) AS anzahl
            FROM (
            SELECT reihenfolge
            FROM  `tblSpielArt`
            WHERE idtblModus =" . $this->modus->getId() . "
            GROUP BY reihenfolge
            ) AS tblSpielArt;";
        //Sollte nur einmal durchlaufen
        foreach ($GLOBALS['DB']->query($sql) as $row) {
            $this->anzahlSpieleHintereinander = $row['anzahl'];
        }
    }

    /**
     * Array für Plätze mit Spiele hintereinander füllen
     */
    private function fillPlatzArray() {
        unset($this->plaetze);
        $this->plaetze = array();
        for ($index = 0; $index < $this->anzahlSpieleHintereinander; $index++) {
            $platzArray = array();
            for ($indexPlatz = 1; $indexPlatz <= $this->anzahlBenoetigtePlaetze; $indexPlatz++) {
                array_push($platzArray, $indexPlatz);
            }
            $this->shuffle_assoc($platzArray);
            array_push($this->plaetze, $platzArray);
        }
    }

    /**
     * Füllt die Tabelle mit den Tabellen mit Nullwerten
     */
    private function fillTabelle() {
        /* @var $spielRunden SpielRunde */
        $spielRunden = $this->ligaSaison->getSpielRunde();
        $mannschaften = $this->ligaSaison->getMannschaften();
        $fehler = 0;
        foreach ($spielRunden as $runde) {
            foreach ($mannschaften as $mannschaft) {
                $sql = "INSERT INTO tblTabelle (idtblSpielRunde,idtblMannschaft) VALUES (" . $runde->getId() . ", " . $mannschaft->getId() . ")";
                $result = $GLOBALS['DB']->exec($sql);
                if ($result <> 1) {
                    $fehler+=1;
                }
            }
        }
        if ($fehler > 0) {
            echo "<br/>$fehler Fehler beim Schreiben";
        }
    }

}

?>
