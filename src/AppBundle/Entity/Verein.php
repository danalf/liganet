<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Document;

/**
 * Acme\DemoBundle\Entity\Tblverein
 *
 * @ORM\Table(name="ln_verein")
 * @ORM\Entity
 */
class Verein {
    
                
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=90, nullable=false)
     */
    private $name;

    /**
     * @var string $namekurz
     *
     * @ORM\Column(name="nameKurz", type="string", length=20, nullable=false)
     */
    private $namekurz;

    /**
     * @var string $kuerzel
     *
     * @ORM\Column(name="kuerzel", type="string", length=5, nullable=false)
     */
    private $kuerzel;

    /**
     * @ORM\OneToOne(targetEntity="Document",cascade={"persist"})
     * @ORM\JoinColumn(name="logo_id", referencedColumnName="id")
     * */
    private $document;

    /**
     * @var integer $nummer
     *
     * @ORM\Column(name="nummer", type="smallint", nullable=false)
     */
    private $nummer;

    /**
     * @var integer $kontakt
     * 
     * @ORM\OneToOne(targetEntity="Spieler")
     * @ORM\JoinColumn(name="kontakt", referencedColumnName="id", nullable=true)
     */
    private $kontakt;

    /**
     * @var string $homepage
     *
     * @ORM\Column(name="homePage", type="string", length=90, nullable=true)
     */
    private $homepage;

    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="vereine")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * @ORM\OneToMany(targetEntity="Spieler", mappedBy="verein")
     */
    protected $spieler;
    
    /**
     * @ORM\OneToMany(targetEntity="Mannschaft", mappedBy="verein")
     */
    protected $mannschaften;
    
    /**
     * @ORM\ManyToMany(targetEntity="Spieler", inversedBy="vereinsleiter")
     * @ORM\JoinTable(name="ln_spieler_vereinsleiter")
     */
    private $leiter;
    
    /**
     * @ORM\OneToMany(targetEntity="Spieltag", mappedBy="austragenderVerein")
     */
    protected $ausgerichteterSpieltag;
    
    /**
     * Variable zum Losen mit der Anzahl der vereinsinternen Duelle
     * @var int 
     */
    protected $anzahlInterneDuelle;
    
    /**
     * Variable zum Losen mit der Anzahl der vereinsinternen Duelle, die bereits nach der Losung berücksichtigt sind
     * @var int 
     */
    protected $anzahlInterneDuelleGespielt;
    
        /**
     * Set anzahlInterneDuelle
     *
     * @param string $name
     */
    public function setAnzahlInterneDuelle($anzahlInterneDuelle) {
        $this->anzahlInterneDuelle = $anzahlInterneDuelle;
    }

    /**
     * Get anzahlInterneDuelle
     *
     * @return int 
     */
    public function getAnzahlInterneDuelle() {
        return $this->anzahlInterneDuelle;
    }
    
       /**
     * Set anzahlInterneDuelleGespielt
     *
     * @param string $name
     */
    public function setAnzahlInterneDuelleGespielt($anzahlInterneDuelleGespielt) {
        $this->anzahlInterneDuelleGespielt = $anzahlInterneDuelleGespielt;
    }

    /**
     * Get anzahlInterneDuelleGespielt
     *
     * @return int 
     */
    public function getAnzahlInterneDuelleGespielt() {
        return $this->anzahlInterneDuelleGespielt;
    }
    
    /**
     * Abfrage zur Losung
     * @return boolean
     */
    public function isInternesDuell(){
        if($this->anzahlInterneDuelle > $this->anzahlInterneDuelleGespielt){
            return TRUE;
        }
        return FALSE;
    }
    /*
     * Zur Lsung. Erhoeht die Anzahl der gespielten intenren Duelle um 1
     */
    public function increaseAnzahlInterneDuelleGespielt(){
        $this->anzahlInterneDuelleGespielt +=1;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Verein
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set namekurz
     *
     * @param string $namekurz
     * @return Verein
     */
    public function setNamekurz($namekurz) {
        $this->namekurz = $namekurz;

        return $this;
    }

    /**
     * Get namekurz
     *
     * @return string 
     */
    public function getNamekurz() {
        return $this->namekurz;
    }

    /**
     * Set kuerzel
     *
     * @param string $kuerzel
     * @return Verein
     */
    public function setKuerzel($kuerzel) {
        $this->kuerzel = $kuerzel;

        return $this;
    }

    /**
     * Get kuerzel
     *
     * @return string 
     */
    public function getKuerzel() {
        return $this->kuerzel;
    }

    /**
     * Set nummer
     *
     * @param integer $nummer
     * @return Verein
     */
    public function setNummer($nummer) {
        $this->nummer = $nummer;

        return $this;
    }

    /**
     * Get nummer
     *
     * @return integer 
     */
    public function getNummer() {
        return $this->nummer;
    }

    /**
     * Set kontakt
     *
     * @param integer $kontakt
     * @return Verein
     */
    public function setKontakt($kontakt) {
        $this->kontakt = $kontakt;

        return $this;
    }

    /**
     * Get kontakt
     *
     * @return integer 
     */
    public function getKontakt() {
        return $this->kontakt;
    }

    /**
     * Set homepage
     *
     * @param string $homepage
     * @return Verein
     */
    public function setHomepage($homepage) {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return string 
     */
    public function getHomepage() {
        return $this->homepage;
    }

    /**
     * Set document
     *
     * @param AppBundle\Entity\Document $document
     * @return Verein
     */
    public function setDocument(\AppBundle\Entity\Document $document = null) {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return AppBundle\Entity\Document 
     */
    public function getDocument() {
        return $this->document;
    }

    /**
     * Set region
     *
     * @param AppBundle\Entity\Region $region
     * @return Verein
     */
    public function setRegion(\AppBundle\Entity\Region $region = null) {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return AppBundle\Entity\Region 
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->spieler = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add spieler
     *
     * @param AppBundle\Entity\Spieler $spieler
     * @return Verein
     */
    public function addSpieler(\AppBundle\Entity\Spieler $spieler) {
        $this->spieler[] = $spieler;

        return $this;
    }

    /**
     * Remove spieler
     *
     * @param AppBundle\Entity\Spieler $spieler
     */
    public function removeSpieler(\AppBundle\Entity\Spieler $spieler) {
        $this->spieler->removeElement($spieler);
    }

    /**
     * Get spieler
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSpieler() {
        return $this->spieler;
    }
    
    public function __toString() {
        if(isset($this->namekurz)){
            return $this->namekurz;
        }else{
            return "";
        }
        
    }


    /**
     * Add mannschaften
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaften
     * @return Verein
     */
    public function addMannschaften(\AppBundle\Entity\Mannschaft $mannschaften)
    {
        $this->mannschaften[] = $mannschaften;
    
        return $this;
    }

    /**
     * Remove mannschaften
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaften
     */
    public function removeMannschaften(\AppBundle\Entity\Mannschaft $mannschaften)
    {
        $this->mannschaften->removeElement($mannschaften);
    }

    /**
     * Get mannschaften
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMannschaften()
    {
        return $this->mannschaften;
    }

    /**
     * Add ausgerichteterSpieltag
     *
     * @param \AppBundle\Entity\Spieltag $ausgerichteterSpieltag
     * @return Verein
     */
    public function addAusgerichteterSpieltag(\AppBundle\Entity\Spieltag $ausgerichteterSpieltag)
    {
        $this->ausgerichteterSpieltag[] = $ausgerichteterSpieltag;
    
        return $this;
    }

    /**
     * Remove ausgerichteterSpieltag
     *
     * @param \AppBundle\Entity\Spieltag $ausgerichteterSpieltag
     */
    public function removeAusgerichteterSpieltag(\AppBundle\Entity\Spieltag $ausgerichteterSpieltag)
    {
        $this->ausgerichteterSpieltag->removeElement($ausgerichteterSpieltag);
    }

    /**
     * Get ausgerichteterSpieltag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAusgerichteterSpieltag()
    {
        return $this->ausgerichteterSpieltag;
    }

    /**
     * Add leiter
     *
     * @param \AppBundle\Entity\Spieler $leiter
     * @return Verein
     */
    public function addLeiter(\AppBundle\Entity\Spieler $leiter)
    {
        $this->leiter[] = $leiter;
    
        return $this;
    }

    /**
     * Remove leiter
     *
     * @param \AppBundle\Entity\Spieler $leiter
     */
    public function removeLeiter(\AppBundle\Entity\Spieler $leiter)
    {
        $this->leiter->removeElement($leiter);
    }

    /**
     * Get leiter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLeiter()
    {
        return $this->leiter;
    }
}
