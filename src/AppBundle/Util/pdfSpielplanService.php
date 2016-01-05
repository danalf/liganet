<?php

namespace AppBundle\Util;

use AppBundle\Entity\Mannschaft;

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
class pdfSpielplanService extends pdfService {

    /**
     *
     * @var \Liganet\CoreBundle\Entity\Mannschaft
     */
    private $mannschaft;

    public function setMannschaft(Mannschaft $mannschaft) {
        $this->mannschaft = $mannschaft;
        $this->ligaSaison = $this->mannschaft->getLigasaison();
    }

    public function create() {
        $this->title = "Spielplan " . $this->mannschaft->getVerein()->getNamekurz() . " " . $this->mannschaft->getRang();
        $this->setDefaults();

        $liga = $this->ligaSaison->getLiga();

        $this->pdf->AddPage();
        //Logo im Hintergrund
        $y = $this->pdf->GetY();
        $this->pdf->SetAlpha(0.15);
        $logo = $this->mannschaft->getVerein()->getDocument();
        if (isset($logo)) {
            $this->pdf->Image($logo->getWebPath(), 50, 75, 100, 0, strtoupper(substr($logo, strpos($logo, ".") + 1)), '', 'M', TRUE, 300, '');
        }
        $this->pdf->SetAlpha(1);
        $this->pdf->SetY($y);
        //Allgemein Infos
        $this->pdf->setCellPaddings(1, 1, 1, 1);
        $this->pdf->setCellMargins(0, 1, 0, 1);
        $this->pdf->SetFont('helvetica', 'B', 8, '', true);
// set color for background
        $this->pdf->SetFillColor(215, 235, 255);
        $this->pdf->MultiCell(30, 6, 'Jahr', 0, 'L', 0, 0);
        $this->pdf->MultiCell(15, 6, $this->ligaSaison->getSaison(), 1, 'C', 1);
        $this->pdf->MultiCell(30, 6, 'Liga', 0, 'L', 0, 0);
        $this->pdf->MultiCell(40, 6, $this->ligaSaison->getLiga(), 1, 'L', 1);
        $this->pdf->MultiCell(30, 6, 'Mannschaft', 0, 'L', 0, 0);
        $this->pdf->MultiCell(70, 6, $this->mannschaft->getVerein()->getNamekurz() . " " . $this->mannschaft->getRang(), 1, 'L', 1, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
        $this->pdf->MultiCell(30, 6, 'Ver.-Nr.', 0, 'L', 0, 0);
        $this->pdf->MultiCell(15, 6, $this->mannschaft->getVerein()->getNummer(), 1, 'C', 1, 1);
        //Termine
        $this->pdf->SetY($this->pdf->GetY() + 5);
        $this->pdf->Write(0, "Termine:", '', FALSE, '', TRUE);
        $this->pdf->SetFont('helvetica', '', 7, '', true);
        $this->pdf->setCellMargins(0, 0, 0, 0);
        $this->pdf->SetFont('helvetica', 'B', 7, '', true);
        $this->pdf->MultiCell(10, 0, "Nr.", 1, 'C', 1, 0);
        $this->pdf->MultiCell(30, 0, "Datum", 1, 'C', 1, 0);
        $this->pdf->MultiCell(15, 0, "Runden", 1, 'C', 1, 0);
        $this->pdf->MultiCell(80, 0, "Spielort", 1, 'L', 1, 1);
        $this->pdf->SetFont('helvetica', '', 7, '', true);
        foreach ($this->ligaSaison->getSpielTage() as $spielTag) {
            $anzahl = count($spielTag->getRunden());
            $this->pdf->MultiCell(10, 0, $spielTag->getNummer(), 1, 'C', 0, 0);
            $this->pdf->MultiCell(30, 0, $spielTag->getDatum()->format("d.m.Y H:i"), 1, 'C', 0, 0);
            $this->pdf->MultiCell(15, 0, $anzahl, 1, 'C', 0, 0);
            $this->pdf->MultiCell(80, 0, $spielTag->getAustragenderVerein(), 1, 'L', 0, 1);
        }
        //Mannschaften
        $this->pdf->SetY($this->pdf->GetY() + 5);
        $this->pdf->SetFont('helvetica', 'B', 8, '', true);
        $this->pdf->Write(0, "Mannschaften:", '', FALSE, '', TRUE);
        $this->pdf->SetFont('helvetica', 'B', 7, '', true);
        $this->pdf->MultiCell(20, 5, "Kürzel", 1, 'C', 1, 0);
        $this->pdf->MultiCell(40, 5, "Name", 1, 'L', 1, 1);
        $this->pdf->SetFont('helvetica', '', 7, '', true);
        $listMannschaften = $this->ligaSaison->getMannschaften();
        foreach ($listMannschaften as $mannschaftListing) {
            $this->pdf->MultiCell(20, 5, $mannschaftListing, 1, 'C', 0, 0);
            $this->pdf->MultiCell(40, 5, $mannschaftListing->getVerein()->getNameKurz() . " " . $mannschaftListing->getRang(), 1, 'L', 0, 1);
        }
        //Platzzuordnung
        $this->pdf->SetY($this->pdf->GetY() + 5);
        $this->pdf->SetFont('helvetica', 'B', 8, '', true);
        $this->pdf->Write(0, "Spielrunden mit Platzzuordnung:", '', FALSE, '', TRUE);
        $this->pdf->SetFont('helvetica', 'B', 7, '', true);
        $this->pdf->MultiCell(10, 5, "Tag", 1, 'C', 1, 0);
        $this->pdf->MultiCell(10, 5, "Nr.", 1, 'C', 1, 0);
        $this->pdf->MultiCell(30, 5, "Begegnung", 1, 'C', 1, 0);

        $spielArten = $this->em->getRepository('AppBundle:SpielArt')->findByModusOrdered($this->ligaSaison->getLiga()->getModus());
        foreach ($spielArten as $spielArt) {
            $this->pdf->MultiCell(10, 5, $spielArt->getNameKurz(), 1, 'C', 1, 0);
        }
        $this->pdf->MultiCell(1, 5, "", 0, 'C', 0, 1);
        $this->pdf->SetFont('helvetica', '', 7, '', true);

        $spieltage = $this->em->getRepository('AppBundle:Spieltag')->findByLigaSaisonOrdered($this->ligaSaison);
        foreach ($spieltage as $spieltag) {
            $runden = $this->em->getRepository('AppBundle:SpielRunde')->findBySpieltagOrdered($spieltag);
            foreach ($runden as $runde) {
                $isInBegegnung = FALSE;
                foreach ($runde->getBegegnungen() as $begegnung) {
                    if ($begegnung->getMannschaft1()->getId() == $this->mannschaft->getId()) {
                        $text = "<strong>" . $this->mannschaft->getVerein()->getKuerzel() . " " . $this->mannschaft->getRang()
                                . "</strong> : " . $begegnung->getMannschaft2()->getVerein()->getKuerzel() . " " . $begegnung->getMannschaft2()->getRang();
                        $isInBegegnung = TRUE;
                    }
                    if ($begegnung->getMannschaft2()->getId() == $this->mannschaft->getId()) {
                        $text =  $begegnung->getMannschaft1()->getVerein()->getKuerzel() . " "
                                . $begegnung->getMannschaft1()->getRang() . " : <strong>" . $this->mannschaft->getVerein()->getKuerzel()
                                . " " . $this->mannschaft->getRang()."</strong>";
                        $isInBegegnung = TRUE;
                    }
                }
                if ($isInBegegnung == FALSE)
                    $text="Spielfrei";

                $this->pdf->MultiCell(10, 5, $runde->getSpieltag()->getNummer(), 1, 'C', 0, 0);
                $this->pdf->MultiCell(10, 5, $runde->getNummer(), 1, 'C', 0, 0);
                $this->pdf->MultiCell(30, 5, $text, 1, 'C', 0, 0, '', '', TRUE, 0, TRUE);
                if (isset($ergebnisse)) {
                    foreach ($ergebnisse as $ergebnis) {
                        $this->pdf->MultiCell(10, 5, $liga->kuerzel . $ergebnis->platz, 1, 'C', 0, 0);
                    }
                    $this->pdf->MultiCell(1, 5, "", 0, 'C', 0, 1);
                } else {
                    for ($index = 0; $index < count($spielArten); $index++) {
                        $this->pdf->MultiCell(10, 5, "", 1, 'C', 0, 0);
                    }
                    $this->pdf->MultiCell(1, 5, "", 0, 'C', 0, 1);
                }
                unset($ergebnisse);
            }
        }
    }

}
