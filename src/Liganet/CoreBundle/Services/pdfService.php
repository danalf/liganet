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
class pdfService {

    protected $webpath = "http://www.liga-net.de/";

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    /**
     *
     * @var Entity\LigaSaison 
     */
    protected $ligaSaison;

    /**
     *
     * @var 
     */
    protected $pdf;

    /**
     * Titel de pdf-Dokuments
     * @var String 
     */
    protected $title;

    public function __construct(EntityManager $entityManager, $pdf) {
        $this->em = $entityManager;
        $this->pdf = $pdf->create();
    }

    public function setLigaSaison(Entity\LigaSaison $ligasaison) {
        $this->ligaSaison = $ligasaison;
        if ($this->ligaSaison->getGesperrt()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    protected function setTitle($title) {
        $this->title = $title;
    }

    public function setDefaults() {
        // create new PDF document
        $this->pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // set document information
        $region = $this->ligaSaison->getLiga()->getRegion()->getName();
        $saison = $this->ligaSaison->getSaison();
        
        $title_long=$region . " - ".$this->ligaSaison->getLiga()." " . $saison . " - " . $this->title;
        //$this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor("liganet");
        $this->pdf->SetTitle($title_long);
        $this->pdf->SetSubject($title_long);
        $this->pdf->SetKeywords($title_long);
        $logo = $this->ligaSaison->getLiga()->getRegion()->getDocument();
        // set default header data
        $this->pdf->SetHeaderData($logo->getWebPath(), 15, $title_long, "");

        // set header and footer fonts
        $this->pdf->setHeaderFont(Array('helvetica', '', 10));
        $this->pdf->setFooterFont(Array('helvetica', '', 10));

        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont('courier');

        //set margins
        $this->pdf->SetMargins(15, 20, 15);
        $this->pdf->SetHeaderMargin(5);
        $this->pdf->SetFooterMargin(10);

        //set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, 15);

        //set image scale factor
        $this->pdf->setImageScale(1.25);

        //set some language-dependent strings
        //$this->pdf->setLanguageArray($l);
    }

    public function ouput() {

        //Close and output PDF document
        $this->pdf->Output($this->ligaSaison->getLiga()->getRegion()->getName() . " " . $this->ligaSaison->getSaison() . "- " . $this->title, 'I');
    }

}

