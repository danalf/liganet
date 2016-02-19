<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="liga_vereine")
 * @ORM\Entity
 */
class VereinExtern {
                
    /**
     * @ORM\Id
     * @ORM\Column(name="Vereinsnummer", type="string", length=50)
     */
    private $id;

    /**
     * @var string 
     *
     * @ORM\Column(name="Verein", type="string", length=250, nullable=true)
     */
    private $name;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Zusatz", type="string", length=250, nullable=true)
     */
    private $zusatz;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Strasse", type="string", length=100, nullable=true)
     */
    private $strasse;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="PLZ", type="string", length=10, nullable=true)
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
     * @ORM\Column(name="TelVerein", type="string", length=100, nullable=true)
     */
    private $telVerein;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="EmailVerein", type="string", length=100, nullable=true)
     */
    private $emailVerein;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPName", type="string", length=50, nullable=true)
     */
    private $ASPName;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPStrasse", type="string", length=50, nullable=true)
     */
    private $ASPStrasse;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPPLZ", type="string", length=50, nullable=true)
     */
    private $ASPPLZ;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPOrt", type="string", length=50, nullable=true)
     */
    private $ASPOrt;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPTel", type="string", length=50, nullable=true)
     */
    private $ASPTel;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="ASPMobil", type="string", length=50, nullable=true)
     */
    private $ASPMobil;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVAName", type="string", length=50, nullable=true)
     */
    private $ligaVAName;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVAStrasse", type="string", length=50, nullable=true)
     */
    private $ligaVAStrasse;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVAPlz", type="string", length=50, nullable=true)
     */
    private $ligaVAPlz;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVAOrt", type="string", length=50, nullable=true)
     */
    private $ligaVAOrt;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVATel", type="string", length=50, nullable=true)
     */
    private $ligaVATel;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaVAEmail", type="string", length=50, nullable=true)
     */
    private $ligaVAEmail;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Aktiv", type="string", length=1)
     */
    private $aktiv;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigabezirkID", type="string", length=10)
     */
    private $ligabezirkID;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="Bezirk", type="string", length=50)
     */
    private $bezirk;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaName", type="string", length=30)
     */
    private $ligaName;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="LigaKuerzel", type="string", length=7)
     */
    private $ligaKuerzel;
    
    /*
     * ab hier generiert
     */

    /**
     * Set id
     *
     * @param string $id
     *
     * @return Verein
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Verein
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set zusatz
     *
     * @param string $zusatz
     *
     * @return Verein
     */
    public function setZusatz($zusatz)
    {
        $this->zusatz = $zusatz;

        return $this;
    }

    /**
     * Get zusatz
     *
     * @return string
     */
    public function getZusatz()
    {
        return $this->zusatz;
    }

    /**
     * Set strasse
     *
     * @param string $strasse
     *
     * @return Verein
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
     * @return Verein
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
     * @return Verein
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
     * Set telVerein
     *
     * @param string $telVerein
     *
     * @return VereinExtern
     */
    public function setTelVerein($telVerein)
    {
        $this->telVerein = $telVerein;

        return $this;
    }

    /**
     * Get telVerein
     *
     * @return string
     */
    public function getTelVerein()
    {
        return $this->telVerein;
    }

    /**
     * Set emailVerein
     *
     * @param string $emailVerein
     *
     * @return VereinExtern
     */
    public function setEmailVerein($emailVerein)
    {
        $this->emailVerein = $emailVerein;

        return $this;
    }

    /**
     * Get emailVerein
     *
     * @return string
     */
    public function getEmailVerein()
    {
        return $this->emailVerein;
    }

    /**
     * Set aSPName
     *
     * @param string $aSPName
     *
     * @return VereinExtern
     */
    public function setASPName($aSPName)
    {
        $this->ASPName = $aSPName;

        return $this;
    }

    /**
     * Get aSPName
     *
     * @return string
     */
    public function getASPName()
    {
        return $this->ASPName;
    }

    /**
     * Set aSPStrasse
     *
     * @param string $aSPStrasse
     *
     * @return VereinExtern
     */
    public function setASPStrasse($aSPStrasse)
    {
        $this->ASPStrasse = $aSPStrasse;

        return $this;
    }

    /**
     * Get aSPStrasse
     *
     * @return string
     */
    public function getASPStrasse()
    {
        return $this->ASPStrasse;
    }

    /**
     * Set aSPPLZ
     *
     * @param string $aSPPLZ
     *
     * @return VereinExtern
     */
    public function setASPPLZ($aSPPLZ)
    {
        $this->ASPPLZ = $aSPPLZ;

        return $this;
    }

    /**
     * Get aSPPLZ
     *
     * @return string
     */
    public function getASPPLZ()
    {
        return $this->ASPPLZ;
    }

    /**
     * Set aSPOrt
     *
     * @param string $aSPOrt
     *
     * @return VereinExtern
     */
    public function setASPOrt($aSPOrt)
    {
        $this->ASPOrt = $aSPOrt;

        return $this;
    }

    /**
     * Get aSPOrt
     *
     * @return string
     */
    public function getASPOrt()
    {
        return $this->ASPOrt;
    }

    /**
     * Set aSPTel
     *
     * @param string $aSPTel
     *
     * @return VereinExtern
     */
    public function setASPTel($aSPTel)
    {
        $this->ASPTel = $aSPTel;

        return $this;
    }

    /**
     * Get aSPTel
     *
     * @return string
     */
    public function getASPTel()
    {
        return $this->ASPTel;
    }

    /**
     * Set aSPMobil
     *
     * @param string $aSPMobil
     *
     * @return VereinExtern
     */
    public function setASPMobil($aSPMobil)
    {
        $this->ASPMobil = $aSPMobil;

        return $this;
    }

    /**
     * Get aSPMobil
     *
     * @return string
     */
    public function getASPMobil()
    {
        return $this->ASPMobil;
    }

    /**
     * Set ligaVAName
     *
     * @param string $ligaVAName
     *
     * @return VereinExtern
     */
    public function setLigaVAName($ligaVAName)
    {
        $this->ligaVAName = $ligaVAName;

        return $this;
    }

    /**
     * Get ligaVAName
     *
     * @return string
     */
    public function getLigaVAName()
    {
        return $this->ligaVAName;
    }

    /**
     * Set ligaVAStrasse
     *
     * @param string $ligaVAStrasse
     *
     * @return VereinExtern
     */
    public function setLigaVAStrasse($ligaVAStrasse)
    {
        $this->ligaVAStrasse = $ligaVAStrasse;

        return $this;
    }

    /**
     * Get ligaVAStrasse
     *
     * @return string
     */
    public function getLigaVAStrasse()
    {
        return $this->ligaVAStrasse;
    }

    /**
     * Set ligaVAPlz
     *
     * @param string $ligaVAPlz
     *
     * @return VereinExtern
     */
    public function setLigaVAPlz($ligaVAPlz)
    {
        $this->ligaVAPlz = $ligaVAPlz;

        return $this;
    }

    /**
     * Get ligaVAPlz
     *
     * @return string
     */
    public function getLigaVAPlz()
    {
        return $this->ligaVAPlz;
    }

    /**
     * Set ligaVAOrt
     *
     * @param string $ligaVAOrt
     *
     * @return VereinExtern
     */
    public function setLigaVAOrt($ligaVAOrt)
    {
        $this->ligaVAOrt = $ligaVAOrt;

        return $this;
    }

    /**
     * Get ligaVAOrt
     *
     * @return string
     */
    public function getLigaVAOrt()
    {
        return $this->ligaVAOrt;
    }

    /**
     * Set ligaVATel
     *
     * @param string $ligaVATel
     *
     * @return VereinExtern
     */
    public function setLigaVATel($ligaVATel)
    {
        $this->ligaVATel = $ligaVATel;

        return $this;
    }

    /**
     * Get ligaVATel
     *
     * @return string
     */
    public function getLigaVATel()
    {
        return $this->ligaVATel;
    }

    /**
     * Set ligaVAEmail
     *
     * @param string $ligaVAEmail
     *
     * @return VereinExtern
     */
    public function setLigaVAEmail($ligaVAEmail)
    {
        $this->ligaVAEmail = $ligaVAEmail;

        return $this;
    }

    /**
     * Get ligaVAEmail
     *
     * @return string
     */
    public function getLigaVAEmail()
    {
        return $this->ligaVAEmail;
    }

    /**
     * Set aktiv
     *
     * @param string $aktiv
     *
     * @return VereinExtern
     */
    public function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;

        return $this;
    }

    /**
     * Get aktiv
     *
     * @return string
     */
    public function getAktiv()
    {
        return $this->aktiv;
    }

    /**
     * Set ligabezirkID
     *
     * @param string $ligabezirkID
     *
     * @return VereinExtern
     */
    public function setLigabezirkID($ligabezirkID)
    {
        $this->ligabezirkID = $ligabezirkID;

        return $this;
    }

    /**
     * Get ligabezirkID
     *
     * @return string
     */
    public function getLigabezirkID()
    {
        return $this->ligabezirkID;
    }

    /**
     * Set bezirk
     *
     * @param string $bezirk
     *
     * @return VereinExtern
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
     * Set ligaName
     *
     * @param string $ligaName
     *
     * @return VereinExtern
     */
    public function setLigaName($ligaName)
    {
        $this->ligaName = $ligaName;

        return $this;
    }

    /**
     * Get ligaName
     *
     * @return string
     */
    public function getLigaName()
    {
        return $this->ligaName;
    }

    /**
     * Set ligaKuerzel
     *
     * @param string $ligaKuerzel
     *
     * @return VereinExtern
     */
    public function setLigaKuerzel($ligaKuerzel)
    {
        $this->ligaKuerzel = $ligaKuerzel;

        return $this;
    }

    /**
     * Get ligaKuerzel
     *
     * @return string
     */
    public function getLigaKuerzel()
    {
        return $this->ligaKuerzel;
    }

}
