<?php

namespace AppBundle\Util;

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
class pdfSpielermeldebogenService extends pdfService {
    

    public function create() {
        $this->title = "Spielermeldung";
        $this->setDefaults();
        
        foreach ($this->ligaSaison->getMannschaften() as $mannschaft) {
            $verein = $mannschaft->getVerein();
            //Logo im Hintergrund
            $this->pdf->AddPage();
            $y = $this->pdf->GetY();
            $this->pdf->SetAlpha(0.15);
            $logo=$verein->getDocument();
            if ($logo) {
                //$this->pdf->Image($logo->getWebPath(), 50, 75, 100, 0, strtoupper(substr($logo, strpos($logo, ".") + 1)), '', 'M', TRUE, 300, '');
            }
            $this->pdf->SetAlpha(1);
            $this->pdf->SetY($y);
            //Allgemein Infos
            $this->pdf->setCellPaddings(1, 1, 1, 1);
            $this->pdf->setCellMargins(0, 1, 0, 1);
            $this->pdf->SetFont('dejavusans', 'B', 8, '', true);
// set color for background
            $this->pdf->SetFillColor(215, 235, 255);
            $this->pdf->MultiCell(30, 6, 'Jahr', 0, 'L', 0, 0);
            $this->pdf->MultiCell(15, 6, $this->ligaSaison->getSaison(), 1, 'C', 1);
            $this->pdf->MultiCell(30, 6, 'Liga', 0, 'L', 0, 0);
            $this->pdf->MultiCell(40, 6, $this->ligaSaison->getLiga(), 1, 'L', 1);
            $this->pdf->MultiCell(30, 6, 'Mannschaft', 0, 'L', 0, 0);
            $this->pdf->MultiCell(70, 6, $verein->getNameKurz() . " " . $mannschaft->getRang(), 1, 'L', 1, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
            $this->pdf->MultiCell(30, 6, 'Ver.-Nr.', 0, 'L', 0, 0);
            $this->pdf->MultiCell(15, 6, $verein->getNummer(), 1, 'C', 1, 1);
            //Spielertabellekopf
            $this->pdf->SetY($this->pdf->GetY() + 5);
            $this->pdf->MultiCell(55, 6, 'Nachname', 1, 'L', 1, 0);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 6, 'Vorname', 1, 'L', 1, 0);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(15, 6, 'Liz.-Nr.', 1, 'C', 1, 0);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(15, 6, 'm/w', 1, 'C', 1, 0);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(15, 6, 'S/E', 1, 'C', 1, 1);
            //Spielertabelle
            $this->pdf->setCellMargins(0, 0, 0, 0);
            foreach ($mannschaft->getMannschaftSpieler() as $mannschaftspieler) {
                $spieler=$mannschaftspieler->getSpieler();
                //Spielerdaten aus Spielertabelle holen
                $this->pdf->MultiCell(55, 6, $spieler->getNachname(), 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(55, 6, $spieler->getVorname(), 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(15, 6, $spieler->getNummerLizenz(), 1, 'C', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $geschlecht = '';
                if ($spieler->getAnrede()->getId() == 1)
                    $geschlecht = 'm';
                if ($spieler->getAnrede()->getId() == 2)
                    $geschlecht = 'w';
                $this->pdf->MultiCell(15, 6, $geschlecht, 1, 'C', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(15, 6, substr($mannschaftspieler->getStatus(), 0, 1), 1, 'C', 0, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
            }
            //Weitere Felder für Spieler, die mit Hand eingetragen werden
            $this->pdf->SetY($this->pdf->GetY() + 5);
            for ($index = 0; $index < 5; $index++) {
                $this->pdf->MultiCell(55, 6, '', 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(55, 6, '', 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(15, 6, '', 1, 'C', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(15, 6, '', 1, 'C', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
                $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
                $this->pdf->MultiCell(15, 6, '', 1, 'C', 0, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'T', TRUE);
            }
            //Unterschriften
            $this->pdf->SetY($this->pdf->GetY() + 10);
            $this->pdf->setCellMargins(0, 1, 0, 1);
            $this->pdf->MultiCell(55, 6, '', 0, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 6, 'Name', 1, 'L', 1, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 6, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 6, 'Unterschrift', 1, 'L', 1, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(55, 12, 'Mannschaftsführer/Trainer', 1, 'L', 1, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 12, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 12, $mannschaft->getCaptain(), 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 12, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 12, '', 1, 'L', 0, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(55, 12, 'Staffelleiter', 1, 'L', 1, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 12, '', 0, 'L', 0, 0);
            $staffelleiter="";
            foreach ($this->ligaSaison->getStaffelleiter() as $value) {
                $staffelleiter .=$value;
            }
            $this->pdf->MultiCell(55, 12, $staffelleiter, 1, 'L', 0, 0, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
            $this->pdf->MultiCell(5, 12, '', 0, 'L', 0, 0);
            $this->pdf->MultiCell(55, 12, '', 1, 'L', 0, 1, '', '', TRUE, 0, FALSE, TRUE, 6, 'M', TRUE);
        }
    }

}
