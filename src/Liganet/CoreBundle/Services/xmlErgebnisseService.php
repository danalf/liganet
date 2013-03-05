<?php
namespace Liganet\CoreBundle\Services;

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
class xmlErgebnisseService {
    
    private $webpath="http://www.liga-net.de/";
    
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
     * @var \DOMDocument
     */
    private $doc;
    
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

    public function createXmlErgebnisse() {
        $this->doc = new \DOMDocument('1.0');
        // we want a nice output
        $this->doc->formatOutput = true;
        $root = $this->doc->createElement('liga');
        $this->doc->appendChild($root);
        //Datum
        $xml = $this->doc->createElement('update');
        $text = $this->doc->createTextNode(date('c'));
        $text = $xml->appendChild($text);
        $root->appendChild($xml);
        //Eigenschaften
        $eigenschaften = $this->doc->createElement('eigenschaften');
        $root->appendChild($eigenschaften);
        //Saison
        $xml = $this->doc->createElement('saison');
        $xml = $eigenschaften->appendChild($xml);
        $text = $this->doc->createTextNode($this->ligaSaison->getSaison());
        $text = $xml->appendChild($text);
        //Region
        $eigenschaften->appendChild($this->createRegion());
        //liga
        $eigenschaften->appendChild($this->createLiga());
        //Modus
        $eigenschaften->appendChild($this->createModus());
        //Mannschaften
        $eigenschaften->appendChild($this->createMannschaften());
        //Aktuelle Tabelle
//Achtung: das ist moeglicherweise nicht das letzte Element
        $spielrunde = $this->ligaSaison->getSpieltage()->last()->getRunden()->last();
        $root->appendChild($this->createTabelle($spielrunde));
        //Spielrunden
        $root->appendChild($this->createSpielrunden());
        //speichern
        $filename=__DIR__ . '/../../../../web/xml/'  . $this->ligaSaison->getSaison() . "_" 
                . $this->ligaSaison->getLiga()->getRegion()->getName()
                ."_".$this->ligaSaison->getLiga()->getName() . ".xml";
        echo "<p>xml erstellen: letztes Tabellen-Element sicherstellen!!!</p>".$filename;
        $success = $this->doc->save($filename);
    }

    private function createRegion() {
        $region=$this->ligaSaison->getLiga()->getRegion();
        $xml_region = $this->doc->createElement('region');
        $attribut = $this->doc->createAttribute('name');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($region->getName());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('logo');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($this->webpath.$region->getDocument()->getWebPath());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabelleSchrift');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($region->getFarbeTabelleSchrift());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabelleHintergrund');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($region->getFarbeTabelleHintergrund());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabelleZeile2Schrift');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($region->getFarbeTabelleZeile2Schrift());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabelleZeile2Hintergrund');
        $xml_region->appendChild($attribut);
        $text = $this->doc->createTextNode($region->getFarbeTabelleZeile2Hintergrund());
        $attribut->appendChild($text);
        return $xml_region;
    }

    private function createLiga() {
        $liga=$this->ligaSaison->getLiga();
        $ligaElement = $this->doc->createElement('liga');
        $attribut = $this->doc->createAttribute('name');
        $ligaElement->appendChild($attribut);
        $text = $this->doc->createTextNode($liga->getName());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabellenKopf');
        $ligaElement->appendChild($attribut);
        $text = $this->doc->createTextNode($liga->getFarbeTabellenKopf());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeTabellenKopfSchrift');
        $ligaElement->appendChild($attribut);
        $text = $this->doc->createTextNode($liga->getFarbeTabellenKopfSchrift());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeUeberschriftHintergrund');
        $ligaElement->appendChild($attribut);
        $text = $this->doc->createTextNode($liga->getFarbeUeberschriftHintergrund());
        $attribut->appendChild($text);
        $attribut = $this->doc->createAttribute('farbeUeberschrift');
        $ligaElement->appendChild($attribut);
        $text = $this->doc->createTextNode($liga->getFarbeUeberschrift());
        $attribut->appendChild($text);
        foreach ($this->ligaSaison->getStaffelleiter() as $staffelleiter) {
             $xml = $this->doc->createElement('staffelleiter');
        $ligaElement->appendChild($xml);
        $text = $this->doc->createTextNode($staffelleiter);
        $xml->appendChild($text);
        }
        return $ligaElement;
    }

    private function createModus() {
        $modus=$this->ligaSaison->getLiga()->getModus();
        $modus_element = $this->doc->createElement('modus');
        $attribut = $this->doc->createAttribute('beschreibung');
        $modus_element->appendChild($attribut);
        $text = $this->doc->createTextNode($modus->getName());
        $attribut->appendChild($text);
        $spielart=$this->em->getRepository('LiganetCoreBundle:SpielArt')->findByModusOrdered($modus);
        foreach ($spielart as $value) {
            $xml = $this->doc->createElement('spiel');
            $modus_element->appendChild($xml);
            $text = $this->doc->createTextNode($value->getNameKurz());
            $xml->appendChild($text);
        }
        return $modus_element;
    }

    private function createMannschaften() {
        $element = $this->doc->createElement('mannschaften');
        foreach ($this->ligaSaison->getMannschaften() as $mannschaft) {
            $element->appendChild($this->createMannschaft($mannschaft));
        }
        return $element;
    }

    private function createMannschaft(Entity\Mannschaft $mannschaft) {
        $element = $this->doc->createElement('mannschaft');
        $attribut = $this->doc->createAttribute('kuerzel');
        $text = $this->doc->createTextNode($mannschaft->getNameKurz());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('name');
        $text = $this->doc->createTextNode($mannschaft->getVerein()->getNamekurz() . " " . $mannschaft->getRang());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('logo');

        $logo=$mannschaft->getVerein()->getDocument();
        if(isset($logo)){
            $text = $this->doc->createTextNode( $webpath.$logo->getWebPath());
        } else{
            $text= $this->doc->createTextNode( "");
        }
        
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        //Spieler hinzufügen
        $spielerMannschaft = $mannschaft->getMannschaftSpieler();
        foreach ($spielerMannschaft as $spieler) {
            $element->appendChild($this->createSpieler($spieler));
        }
        return $element;
    }

    private function createSpieler(Entity\MannschaftSpieler $spieler) {
        $element = $this->doc->createElement('spieler');
        $attribut = $this->doc->createAttribute('name');
        $text = $this->doc->createTextNode($spieler->getSpieler());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('lizenz');
        $text = $this->doc->createTextNode($spieler->getSpieler()->getNummerlizenz());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('status');
        $text = $this->doc->createTextNode($spieler->getStatus());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('id');
        $text = $this->doc->createTextNode($spieler->getSpieler()->getId());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        return $element;
    }

    private function createSpielrunden() {
        $element = $this->doc->createElement('spielrunden');
        $spieltage=$this->em->getRepository('LiganetCoreBundle:Spieltag')->findByLigaSaisonOrdered($this->ligaSaison);
        foreach ($spieltage as $spieltag) {
            foreach ($spieltag->getRunden() as $runde) {
                $element->appendChild($this->createSpielRunde($runde));
            }
        }
        return $element;
    }

    private function createSpielRunde(Entity\SpielRunde $runde) {
        $element = $this->doc->createElement('spielrunde');
        $attribut = $this->doc->createAttribute('nummer');
        $text = $this->doc->createTextNode($runde->getNummer());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        //Spieltagsinformationen
        $spieltag = $runde->getSpieltag();
        $attribut = $this->doc->createAttribute('spieltagnr');
        $text = $this->doc->createTextNode($spieltag->getNummer());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('datum');
        $text = $this->doc->createTextNode($spieltag->getDatum()->format('c'));
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('ort');
        $text = $this->doc->createTextNode($spieltag->getAustragenderVerein());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        //begegnungen
        $begegnungen = $this->doc->createElement('begegnungen');
        //von hinten durch die Brust ins Auge, weil $runde->getBegegnungen() warumauchimer nicht funktioniert
        $runde1=$this->em->getRepository('LiganetCoreBundle:Begegnung')->findBy(array('spielRunde' => $runde->getId()));
        
        foreach ($runde1 as $begegnung) {
            $begegnungen->appendChild($this->createBegegnung($begegnung));
        }
        $element->appendChild($begegnungen);
        $element->appendChild($this->createTabelle($runde));
        return $element;
    }

    private function createTabelle(Entity\SpielRunde $spielrunde) {
        $element = $this->doc->createElement('tabelle');
        echo "sp".$spielrunde->getTabelle()->count();
        $tabellen=$this->em->getRepository('LiganetCoreBundle:Tabelle')->findBy(array('spielrunde' => $spielrunde->getId()), array('rang' => 'ASC'));
        foreach ($tabellen as $tab) {
            $element->appendChild($this->createTabellenZeile($tab));
        }
        return $element;
    }

    private function createTabellenZeile(Entity\Tabelle $tabelle) {
        $element = $this->doc->createElement('platz');
        $attribut = $this->doc->createAttribute('nummer');
        $text = $this->doc->createTextNode($tabelle->getRang());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('kuerzel');
        $text = $this->doc->createTextNode($tabelle->getMannschaft()->getNameKurz());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('name');
        $text = $this->doc->createTextNode($tabelle->getMannschaft()->getVerein()->getNamekurz() . " " . $tabelle->getMannschaft()->getRang());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('kugeln_eigen');
        $text = $this->doc->createTextNode($tabelle->getKugeln1());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('kugeln_gegner');
        $text = $this->doc->createTextNode($tabelle->getKugeln2());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('diff');
        $text = $this->doc->createTextNode($tabelle->getDifferenz());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('spiele_eigen');
        $text = $this->doc->createTextNode($tabelle->getSpiele1());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('spiele_gegner');
        $text = $this->doc->createTextNode($tabelle->getSpiele2());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('punkte_eigen');
        $text = $this->doc->createTextNode($tabelle->getPunkte1());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('punkte_gegner');
        $text = $this->doc->createTextNode($tabelle->getPunkte2());
        $attribut->appendChild($text);
        $element->appendChild($attribut);

        return $element;
    }

    private function createBegegnung(Entity\Begegnung $begegnung) {
        $element = $this->doc->createElement('begegnung');
        $xml = $this->doc->createElement('team1');
        $text = $this->doc->createTextNode($begegnung->getMannschaft1()->getNameKurz());
        $xml->appendChild($text);
        $element->appendChild($xml);
        $xml = $this->doc->createElement('team2');
        $text = $this->doc->createTextNode($begegnung->getMannschaft2()->getNameKurz());
        $xml->appendChild($text);
        $element->appendChild($xml);
        //Kugeln
        $xml = $this->doc->createElement('kugeln');
        $attribut = $this->doc->createAttribute('team1');
        $text = $this->doc->createTextNode($begegnung->getKugeln1());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $attribut = $this->doc->createAttribute('team2');
        $text = $this->doc->createTextNode($begegnung->getKugeln2());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $element->appendChild($xml);
        //Siege
        $xml = $this->doc->createElement('siege');
        $attribut = $this->doc->createAttribute('team1');
        $text = $this->doc->createTextNode($begegnung->getSiege1());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $attribut = $this->doc->createAttribute('team2');
        $text = $this->doc->createTextNode($begegnung->getSiege2());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $element->appendChild($xml);
        //Punkte
        $xml = $this->doc->createElement('punkt');
        $attribut = $this->doc->createAttribute('team1');
        $text = $this->doc->createTextNode($begegnung->getPunkt1());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $attribut = $this->doc->createAttribute('team2');
        $text = $this->doc->createTextNode($begegnung->getPunkt2());
        $attribut->appendChild($text);
        $xml->appendChild($attribut);
        $element->appendChild($xml);
        //spiele
        $ergebnisse = $begegnung->getErgebnisse();
        $spiele = $this->doc->createElement('spiele');
        foreach ($ergebnisse as $ergebnis) {
            $spiele->appendChild($this->createErgebnis($ergebnis));
        }
        $element->appendChild($spiele);
        return $element;
    }

    private function createErgebnis(Entity\Ergebnis $ergebnis) {
        $element = $this->doc->createElement('spiel');
        $attribut = $this->doc->createAttribute('id');
        $text = $this->doc->createTextNode($ergebnis->getId());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('nummer');
        $text = $this->doc->createTextNode($ergebnis->getSpielArt()->getNummer());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('platz');
        $text = $this->doc->createTextNode($ergebnis->getPlatz());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('kugeln1');
        $text = $this->doc->createTextNode($ergebnis->getKugeln1());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        $attribut = $this->doc->createAttribute('kugeln2');
        $text = $this->doc->createTextNode($ergebnis->getKugeln2());
        $attribut->appendChild($text);
        $element->appendChild($attribut);
        if ($ergebnis->getSpieler11() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler11());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("1");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler11() == $ergebnis->getErsatzFuer1()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }
        if ($ergebnis->getSpieler12()) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler12());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("1");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler12() == $ergebnis->getErsatzFuer1()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }
        if ($ergebnis->getSpieler13() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler13());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("1");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler13() == $ergebnis->getErsatzFuer1()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }

        if ($ergebnis->getErsatz1() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getErsatz1());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("1");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('eingewechselt');
            $text = $this->doc->createTextNode("true");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $element->appendChild($spieler);
        }

        if ($ergebnis->getSpieler21() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler21());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("2");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler21() == $ergebnis->getErsatzFuer2()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }
        if ($ergebnis->getSpieler22() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler22());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("2");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler22() == $ergebnis->getErsatzFuer2()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }
        if ($ergebnis->getSpieler23() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getSpieler23());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("2");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            if ($ergebnis->getSpieler23() == $ergebnis->getErsatzFuer2()) {
                $attribut = $this->doc->createAttribute('ausgewechselt');
                $text = $this->doc->createTextNode("true");
                $attribut->appendChild($text);
                $spieler->appendChild($attribut);
            }
            $element->appendChild($spieler);
        }
        
        if ($ergebnis->getErsatz2() ) {
            $spieler = $this->doc->createElement('spieler');
            $attribut = $this->doc->createAttribute('nummer');
            $text = $this->doc->createTextNode($ergebnis->getErsatz2());
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('team');
            $text = $this->doc->createTextNode("2");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $attribut = $this->doc->createAttribute('eingewechselt');
            $text = $this->doc->createTextNode("true");
            $attribut->appendChild($text);
            $spieler->appendChild($attribut);
            $element->appendChild($spieler);
        }
        
        return $element;
    }


}

