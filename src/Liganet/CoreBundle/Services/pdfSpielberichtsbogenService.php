<?php

namespace Liganet\CoreBundle\Services;
use Liganet\CoreBundle\Services\pdfService;

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
class pdfSpielberichtsbogenService extends pdfService {
    
    

    public function create() {
        $this->title = "Spielbericht";
        $this->setDefaults();

        $spieltage = $this->em->getRepository('LiganetCoreBundle:Spieltag')->findByLigaSaisonOrdered($this->ligaSaison);
        $spieltag=new \Liganet\CoreBundle\Entity\Spieltag;
        foreach ($spieltage as $spieltag) {
            $runden = $this->em->getRepository('LiganetCoreBundle:SpielRunde')->findBySpieltagOrdered($spieltag);
            foreach ($runden as $runde) {
                $begegnungen = $runde->getBegegnungen();
                $begegnung=new \Liganet\CoreBundle\Entity\Begegnung;
                
                foreach ($begegnungen as $begegnung) {
                // add a page
                    $this->pdf->AddPage();
                    $this->pdf->setCellPaddings(1, 1, 1, 1);
                    $this->pdf->setCellMargins(0, 1, 0, 1);
                    $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                    // set color for background
                    $this->pdf->SetFillColor(215, 235, 255);
                    $this->pdf->MultiCell(30, 0, 'Liga', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(60, 0, $this->ligaSaison->getLiga(), 1, 'C', 1);
                    $this->pdf->MultiCell(30, 0, 'Spielort', 0, 'L', 0, 0);
                    $verein=$spieltag->getAustragenderVerein();
                    if(!isset($verein)){
                        $verein="";
                    }
                    $this->pdf->MultiCell(60, 6, $verein, 1, 'L', 1, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                    $this->pdf->MultiCell(30, 0, 'Spieltag', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(10, 0, $spieltag->getNummer(), 1, 'C', 1, 0);
                    $this->pdf->MultiCell(10, 0, '', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(40, 0, $spieltag->getDatum()->format("d.m.Y"), 1, 'C', 1);
                    $this->pdf->MultiCell(30, 0, 'Begegnung', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(10, 0, $runde->getNummer(), 1, 'C', 1);
                    $this->pdf->MultiCell(18, 0, '', 0, 'L', 0, 0);
                    $this->pdf->setCellPaddings(0, 0, 0, 0);
                    $this->pdf->setCellMargins(0, 1, 0, 1);

                    $logo = $begegnung->getMannschaft1()->getVerein()->getDocument();
                    if(isset($logo)){
                        $this->pdf->MultiCell(54, 0, '<img src="'.$logo->getWebPath()  . '" height="60" />', 0, 'C', 0, 0, '', '', true, 0, true);
                    } else {
                        $this->pdf->MultiCell(54, 0, '<img  height="60" />', 0, 'C', 0, 0, '', '', true, 0, true);
                    }
                    $this->pdf->MultiCell(4, 0, '', 0, 'L', 0, 0);
                    $logo = $begegnung->getMannschaft2()->getVerein()->getDocument();
                    if(isset($logo)){
                        $this->pdf->MultiCell(54, 0, '<img src="'.$logo->getWebPath()  . '" height="60" />', 0, 'C', 0, 0, '', '', true, 0, true);
                    }else {
                        $this->pdf->MultiCell(54, 0, '<img  height="60" />', 0, 'C', 0, 0, '', '', true, 0, true);
                    }
                    $this->pdf->SetY(75);
                    //$this->pdf->Ln();
                    $this->pdf->setCellPaddings(1, 1, 1, 1);
                    $this->pdf->MultiCell(14, 0, '', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(4, 0, '', 0, 'L', 0, 0);
                    $this->pdf->MultiCell(8, 0, 'A', 1, 'C', 0, 0);
                    $this->pdf->MultiCell(46, 0, $begegnung->getMannschaft1(), 1, 'C', 1, 0);
                    $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0);
                    $this->pdf->MultiCell(46, 0, $begegnung->getMannschaft2(), 1, 'C', 1, 0);
                    $this->pdf->MultiCell(8, 0, 'B', 1, 'C', 0, 1);
                    
                    $ergebnisse = $this->em->getRepository('LiganetCoreBundle:Ergebnis')->findByBegegnungOrdered($begegnung);
                    $ergebnis = new \Liganet\CoreBundle\Entity\Ergebnis();
                    foreach ($ergebnisse as $ergebnis) {
                        $spielart = $ergebnis->getSpielArt();
                        $this->pdf->setCellMargins(0, 2, 0, 0);
                        $this->pdf->setCellPaddings(0, 0, 0, 0);
                        //$this->pdf->Write(1, '', '', false, '', true);
                        $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                        $this->pdf->MultiCell(18, 0, '', 0, 'L', 0, 0);
                        $this->pdf->MultiCell(54, 0, $spielart->getName(), 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(54, 0, $spielart->getName(), 0, 'C', 0, 1);
                        $this->pdf->setCellMargins(0, 0, 0, 0);
                        $this->pdf->SetFont('dejavusans', '', 7, '', true);
                        $this->pdf->MultiCell(14, 0, 'Platz', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'L', 0, 0);
                        $this->pdf->MultiCell(54, 0, "Eingesetzte Spieler-Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(54, 0, "Eingesetzte Spieler-Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(24, 0, "Resultat", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(16, 0, "Sieger A/B", 0, 'C', 0, 1);
                        $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                        $this->pdf->setCellPaddings(1, 1, 1, 1);
                        $this->pdf->setCellMargins(0, 1, 0, 1);
                        $this->pdf->MultiCell(14, 0, $this->ligaSaison->getLiga()->getKuerzel() . " ".$ergebnis->getPlatz(), 1, 'C', 1, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'L', 0, 0);
                        switch ($spielart->getAnzahlSpieler()) {
                            case 1:
                                $this->pdf->MultiCell(18, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, '', 0, 'C', 0, 0);
                                break;
                            case 2:
                                $this->pdf->MultiCell(9, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(9, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(9, 0, '', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(9, 0, '', 0, 'C', 0, 0);
                                break;
                            case 3:
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);
                                $this->pdf->MultiCell(18, 0, "", 1, 'L', 1, 0);

                                break;

                            default:
                                break;
                        }
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(10, 0, "", 1, 'C', 1, 0);
                        $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(10, 0, "", 1, 'C', 1, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(16, 0, "", 1, 'C', 1, 1);
                        //Auswechselspieler
                        $this->pdf->setCellMargins(0, 0, 0, 0);
                        $this->pdf->setCellPaddings(0, 0, 0, 0);
                        $this->pdf->SetFont('dejavusans', '', 7, '', true);
                        $this->pdf->MultiCell(18, 0, '', 0, 'L', 0, 0);
                        $this->pdf->MultiCell(54, 0, "Auswechselspieler", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(4, 0, '', 0, 'C', 0, 0);
                        $this->pdf->MultiCell(54, 0, "Auswechselspieler", 0, 'C', 0, 1);
                        $this->pdf->setCellPaddings(1, 1, 1, 1);
                        $this->pdf->MultiCell(18, 0, '', 0, 'L', 0, 0);
                        $this->pdf->MultiCell(9, 0, "Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(10, 0, "", 1, 'L', 1, 0);
                        $this->pdf->MultiCell(16, 0, "für Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(10, 0, "", 1, 'L', 1, 0);
                        $this->pdf->MultiCell(13, 0, '', 0, 'L', 0, 0);
                        $this->pdf->MultiCell(9, 0, "Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(10, 0, "", 1, 'L', 1, 0);
                        $this->pdf->MultiCell(16, 0, "für Nr.", 0, 'C', 0, 0);
                        $this->pdf->MultiCell(9, 0, "", 1, 'L', 1, 1);
                    }
                    //Unterschriftsboxen
                    $this->pdf->Write(2, '', '', false, '', true);
                    $this->pdf->setCellMargins(0, 0, 0, 0);
                    $this->pdf->setCellPaddings(0, 0, 0, 0);
                    $this->pdf->SetFont('dejavusans', 'B', 6, '', true);
                    $this->pdf->MultiCell(70, 15, 'Unterschrift Trainer/Mannschaftsführer Verein A', 1, 'L', 1, 1);
                    $this->pdf->MultiCell(70, 15, 'Unterschrift Trainer/Mannschaftsführer Verein B', 1, 'L', 1, 1);
                    $this->pdf->MultiCell(70, 15, 'Unterschrift Schiedsrichter/Spiel-, Staffelleiter', 1, 'L', 1, 1);
                    $this->pdf->Write(2, '', '', false, '', true);
                    //$this->pdf->MultiCell(160, 25, 'Besondere Vorkommnisse:', 1, 'L', 1, 1);
                    $this->pdf->MultiCell(160, 20, 'Besondere Vorkommnisse:', 1, 'L', 1, 1);
                    $this->pdf->setCellPaddings(1, 1, 1, 1);
                    $this->pdf->setCellMargins(0, 1, 0, 1);
                    $this->pdf->SetFont('dejavusans', 'B', 6, '', true);
                    $startx = 100;
                    $starty = 202;
                    $this->pdf->MultiCell(36, 0, 'Kugeln Gesamt', 0, 'C', 0, 1, $startx + 8, $starty);
                    $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                    $starty+=4.5;
                    $this->pdf->MultiCell(8, 0, 'A', 0, 'C', 0, 0, $startx, $starty);
                    $this->pdf->MultiCell(16, 0, "", 1, 'C', 1, 0, $startx + 8, $starty);
                    $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0, $startx + 24, $starty);
                    $this->pdf->MultiCell(16, 0, "", 1, 'C', 1, 0, $startx + 28, $starty);
                    $this->pdf->MultiCell(8, 0, 'B', 0, 'C', 0, 0, $startx + 44, $starty);
                    $starty+=5;
                    $this->pdf->SetFont('dejavusans', '', 6, '', true);
                    $this->pdf->MultiCell(36, 0, '(z.B. 46:29)', 0, 'C', 0, 1, $startx + 8, $starty);
                    $starty+=4.5;
                    $currentx = $startx + 8;
                    $this->pdf->SetFont('dejavusans', 'B', 6, '', true);
                    $spielarten=$this->em->getRepository('LiganetCoreBundle:SpielArt')->findByModusOrdered($this->ligaSaison->getLiga()->getModus());
                    foreach ($spielarten as $spielart) {
                        $this->pdf->MultiCell(10, 0, $spielart->getNameKurz(), 0, 'C', 0, 0, $currentx, $starty);
                        $currentx+=10;
                    }
                    $this->pdf->MultiCell(8, 0, '', 0, 'C', 0, 0, $currentx, $starty);
                    $currentx+=8;
                    $this->pdf->MultiCell(10, 0, 'Siege', 0, 'C', 0, 0, $currentx, $starty);
                    $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                    $starty+=4.5;
                    $this->pdf->MultiCell(8, 0, 'A', 0, 'C', 0, 0, $startx, $starty);
                    $currentx = $startx + 8;
                    foreach ($spielarten as $spielart) {
                        $this->pdf->MultiCell(10, 4, "", 1, 'C', 1, 0, $currentx, $starty);
                        $currentx+=10;
                    }
                    $this->pdf->MultiCell(8, 0, '=', 0, 'C', 0, 0, $currentx, $starty);
                    $currentx+=8;
                    $this->pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, $currentx, $starty);
                    $starty+=5;
                    $this->pdf->MultiCell(8, 0, 'B', 0, 'C', 0, 0, $startx, $starty);
                    $currentx = $startx + 8;
                    foreach ($spielarten as $spielart) {
                        $this->pdf->MultiCell(10, 4, "", 1, 'C', 1, 0, $currentx, $starty);
                        $currentx+=10;
                    }
                    $this->pdf->MultiCell(8, 0, '=', 0, 'C', 0, 0, $currentx, $starty);
                    $currentx+=8;
                    $this->pdf->MultiCell(10, 4, '', 1, 'C', 1, 0, $currentx, $starty);
                    $starty+=5;
                    $this->pdf->SetFont('dejavusans', '', 6, '', true);
                    $this->pdf->MultiCell(50, 0, '(z.B. Sieger T1=1; Verlierer T1=0)', 0, 'C', 0, 1, $startx + 8, $starty);
                    $starty+=5.5;
                    $this->pdf->SetFont('dejavusans', 'B', 6, '', true);
                    $this->pdf->MultiCell(36, 0, 'Spielpunkt', 0, 'C', 0, 1, $startx + 8, $starty);
                    $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
                    $starty+=4.5;
                    $this->pdf->MultiCell(8, 0, 'A', 0, 'C', 0, 0, $startx, $starty);
                    $this->pdf->MultiCell(16, 0, "", 1, 'C', 1, 0, $startx + 8, $starty);
                    $this->pdf->MultiCell(4, 0, ':', 0, 'C', 0, 0, $startx + 24, $starty);
                    $this->pdf->MultiCell(16, 0, "", 1, 'C', 1, 0, $startx + 28, $starty);
                    $this->pdf->MultiCell(8, 0, 'B', 0, 'C', 0, 0, $startx + 44, $starty);
                    $starty+=5;
                    $this->pdf->SetFont('dejavusans', '', 6, '', true);
                    $this->pdf->MultiCell(36, 0, '(Sieger=1; Verlierer=0)', 0, 'C', 0, 1, $startx + 8, $starty);
                }
            }
        }
        // move pointer to last page
        $this->pdf->lastPage();
    }

}
