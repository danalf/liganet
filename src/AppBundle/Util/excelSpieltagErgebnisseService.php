<?php

namespace AppBundle\Util;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity;
use \PHPExcel;

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
class excelSpieltagErgebnisseService {

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    /**
     *
     * @var Entity\Spieltag 
     */
    private $spieltag;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function setSpieltag(Entity\Spieltag $spieltag) {
        $this->spieltag = $spieltag;
    }

    public function createExcel() {
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->setActiveSheetIndex(0);

        $runden = $this->em->getRepository('AppBundle:SpielRunde')->findBySpieltagOrdered($this->spieltag);
        /**
         * @var Entity\SpielRunde
         */
        $runde = array_pop($runden);

        $tabelle = $this->em->getRepository('AppBundle:Tabelle')->findByRunde($runde->getId());
        $worksheet->setCellValue("A1", "Rang");
        $worksheet->setCellValue("B1", "Mannschaft");
        $worksheet->setCellValue("C1", "Kugeln");
        $worksheet->setCellValue("F1", "Diff");
        $worksheet->setCellValue("G1", "Spiele");
        $worksheet->setCellValue("J1", "Punkte");

        $worksheet->mergeCells("C1:E1");
        $worksheet->mergeCells("G1:I1");
        $worksheet->mergeCells("J1:L1");
        
        for ($index = 0; $index < count($tabelle); $index++) {
            /**
             * @var Entity\Tabelle
             */
            $zeile = $tabelle[$index];
            $nrZeile = $index + 2;
            $worksheet->setCellValue("A" . $nrZeile, $zeile->getRang());
            $worksheet->setCellValue("B" . $nrZeile, $zeile->getMannschaft()->getName());
            $worksheet->setCellValue("C" . $nrZeile, $zeile->getKugeln1());
            $worksheet->setCellValue("D" . $nrZeile, ":");
            $worksheet->setCellValue("E" . $nrZeile, $zeile->getKugeln2());
            $worksheet->setCellValue("F" . $nrZeile, $zeile->getDifferenz());
            $worksheet->setCellValue("G" . $nrZeile, $zeile->getSpiele1());
            $worksheet->setCellValue("H" . $nrZeile, ":");
            $worksheet->setCellValue("I" . $nrZeile, $zeile->getSpiele2());
            $worksheet->setCellValue("J" . $nrZeile, $zeile->getPunkte1());
            $worksheet->setCellValue("K" . $nrZeile, ":");
            $worksheet->setCellValue("L" . $nrZeile, $zeile->getPunkte2());
        }

        foreach (range('A', 'L') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set properties
        //echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Liganet");
        $objPHPExcel->getProperties()->setLastModifiedBy("Liganet");
        $objPHPExcel->getProperties()->setTitle("Liganet Spieltag Ergebnisse");
        $objPHPExcel->getProperties()->setSubject("Liganet Spieltag Ergebnisse");
        $objPHPExcel->getProperties()->setDescription("Liganet document for Office 2007 XLSX, generated using PHP classes.");

        // Rename sheet
        $nameLiga = $runde->getSpieltag()->getLigaSaison()->getLiga()->getKuerzel() . " " . $runde->getSpieltag()->getLigaSaison()->getSaison()->getSaison() . " Runde " . $runde->getNummer();
        $objPHPExcel->getActiveSheet()->setTitle('Tabelle');

        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
//
        //header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// It will be called file.xls
        header('Content-Disposition: attachment; filename="' . $nameLiga . '.xls"');

// Write file to the browser
        $objWriter->save('php://output');

        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
    }

}
