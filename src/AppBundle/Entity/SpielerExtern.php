<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="liga_lizenzspieler")
 * @ORM\Entity
 */
class SpielerExtern {
                
    /**
     * @ORM\Id
     * @ORM\Column(name="SpielerID", type="integer")
     */
    private $id;

    /**
     * @var string 
     *
     * @ORM\Column(name="Vorname", type="string", length=50, nullable=true)
     */
    private $vorname;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Nachname", type="string", length=50, nullable=true)
     */
    private $nachname;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="GebDatum", type="datetime", nullable=true)
     */
    private $gebDatum;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Nationalitaet", type="string", length=50, nullable=true)
     */
    private $nationalitaet;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Strasse", type="string", length=50, nullable=true)
     */
    private $strasse;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="PLZ", type="string", length=50, nullable=true)
     */
    private $plz;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Ort", type="string", length=50, nullable=true)
     */
    private $ort;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Telefon", type="string", length=50, nullable=true)
     */
    private $telefon;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Email", type="string", length=50, nullable=true)
     */
    private $email;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Geschlecht", type="string", length=50, nullable=true)
     */
    private $geschlecht;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Lizenznummer", type="string", length=50, nullable=true)
     */
    private $lizenznummer;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LizenzJahr", type="integer")
     */
    private $lizenzJahr;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Verein", type="string", length=250, nullable=true)
     */
    private $verein;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaBezirkID", type="integer")
     */
    private $ligaBezirkID;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Bezirk", type="string", length=50, nullable=true)
     */
    private $bezirk;
    
    /**
     * @ORM\OneToOne(targetEntity="Spieler", mappedBy="spielerExtern")
     */
    protected $spieler;
    

    /*
     * ab hier generiert
     */

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return SpielerExtern
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set vorname
     *
     * @param string $vorname
     *
     * @return SpielerExtern
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;

        return $this;
    }

    /**
     * Get vorname
     *
     * @return string
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Set nachname
     *
     * @param string $nachname
     *
     * @return SpielerExtern
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;

        return $this;
    }

    /**
     * Get nachname
     *
     * @return string
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * Set gebDatum
     *
     * @param \DateTime $gebDatum
     *
     * @return SpielerExtern
     */
    public function setGebDatum($gebDatum)
    {
        $this->gebDatum = $gebDatum;

        return $this;
    }

    /**
     * Get gebDatum
     *
     * @return \DateTime
     */
    public function getGebDatum()
    {
        return $this->gebDatum;
    }

    /**
     * Set nationalitaet
     *
     * @param string $nationalitaet
     *
     * @return SpielerExtern
     */
    public function setNationalitaet($nationalitaet)
    {
        $this->nationalitaet = $nationalitaet;

        return $this;
    }

    /**
     * Get nationalitaet
     *
     * @return string
     */
    public function getNationalitaet()
    {
        return $this->nationalitaet;
    }

    /**
     * Set strasse
     *
     * @param string $strasse
     *
     * @return SpielerExtern
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;

        return $this;
    }

    /**
     * Get strasse
     *
     * @return string
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * Set plz
     *
     * @param string $plz
     *
     * @return SpielerExtern
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;

        return $this;
    }

    /**
     * Get plz
     *
     * @return string
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * Set ort
     *
     * @param string $ort
     *
     * @return SpielerExtern
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;

        return $this;
    }

    /**
     * Get ort
     *
     * @return string
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return SpielerExtern
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return SpielerExtern
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set geschlecht
     *
     * @param string $geschlecht
     *
     * @return SpielerExtern
     */
    public function setGeschlecht($geschlecht)
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    /**
     * Get geschlecht
     *
     * @return string
     */
    public function getGeschlecht()
    {
        return $this->geschlecht;
    }

    /**
     * Set lizenznummer
     *
     * @param string $lizenznummer
     *
     * @return SpielerExtern
     */
    public function setLizenznummer($lizenznummer)
    {
        $this->lizenznummer = $lizenznummer;

        return $this;
    }

    /**
     * Get lizenznummer
     *
     * @return string
     */
    public function getLizenznummer()
    {
        return $this->lizenznummer;
    }

    /**
     * Set lizenzJahr
     *
     * @param integer $lizenzJahr
     *
     * @return SpielerExtern
     */
    public function setLizenzJahr($lizenzJahr)
    {
        $this->lizenzJahr = $lizenzJahr;

        return $this;
    }

    /**
     * Get lizenzJahr
     *
     * @return integer
     */
    public function getLizenzJahr()
    {
        return $this->lizenzJahr;
    }

    /**
     * Set verein
     *
     * @param string $verein
     *
     * @return SpielerExtern
     */
    public function setVerein($verein)
    {
        $this->verein = $verein;

        return $this;
    }

    /**
     * Get verein
     *
     * @return string
     */
    public function getVerein()
    {
        return $this->verein;
    }

    /**
     * Set ligaBezirkID
     *
     * @param integer $ligaBezirkID
     *
     * @return SpielerExtern
     */
    public function setLigaBezirkID($ligaBezirkID)
    {
        $this->ligaBezirkID = $ligaBezirkID;

        return $this;
    }

    /**
     * Get ligaBezirkID
     *
     * @return integer
     */
    public function getLigaBezirkID()
    {
        return $this->ligaBezirkID;
    }

    /**
     * Set bezirk
     *
     * @param string $bezirk
     *
     * @return SpielerExtern
     */
    public function setBezirk($bezirk)
    {
        $this->bezirk = $bezirk;

        return $this;
    }

    /**
     * Get bezirk
     *
     * @return string
     */
    public function getBezirk()
    {
        return $this->bezirk;
    }

    /**
     * Set spieler
     *
     * @param \AppBundle\Entity\Spieler $spieler
     *
     * @return SpielerExtern
     */
    public function setSpieler(\AppBundle\Entity\Spieler $spieler = null)
    {
        $this->spieler = $spieler;

        return $this;
    }

    /**
     * Get spieler
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler()
    {
        return $this->spieler;
    }
}
