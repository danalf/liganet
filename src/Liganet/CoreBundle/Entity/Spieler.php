<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liganet\CoreBundle\Entity\Spieler
 *
 * @ORM\Table(name="ln_spieler")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\SpielerRepository")
 */
class Spieler {

    /**
     * @var integer $idtblspieler
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $vorname
     *
     * @ORM\Column(name="vorname", type="string", length=45, nullable=false)
     */
    private $vorname;

    /**
     * @var string $nachname
     *
     * @ORM\Column(name="nachname", type="string", length=45, nullable=false)
     */
    private $nachname;

    /**
     * @var string $strasse
     *
     * @ORM\Column(name="strasse", type="string", length=45, nullable=true)
     */
    private $strasse;

    /**
     * @var string $lkz
     *
     * @ORM\Column(name="lkz", type="string", length=3, nullable=true)
     */
    private $lkz;

    /**
     * @var string $plz
     *
     * @ORM\Column(name="plz", type="string", length=6, nullable=true)
     */
    private $plz;

    /**
     * @var string $ort
     *
     * @ORM\Column(name="ort", type="string", length=45, nullable=true)
     */
    private $ort;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string $telefon
     *
     * @ORM\Column(name="telefon", type="string", length=20, nullable=true)
     */
    private $telefon;

    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax", type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @var string $bild
     *
     * @ORM\Column(name="bild", type="string", length=45, nullable=true)
     */
    private $bild;

    /**
     * @var integer $nummerlizenz
     *
     * @ORM\Column(name="nummerLizenz", type="smallint", nullable=true)
     */
    private $nummerlizenz;

    /**
     * @var boolean $trainer
     *
     * @ORM\Column(name="trainer", type="boolean", nullable=true)
     */
    private $trainer;

    /**
     * @var boolean $schiedsrichter
     *
     * @ORM\Column(name="schiedsrichter", type="boolean", nullable=true)
     */
    private $schiedsrichter;

    /**
     * @ORM\ManyToOne(targetEntity="Spieler")
     * @ORM\JoinColumn(name="veraendertVon", referencedColumnName="id")
     */
    private $veraendertvon;

    /**
     * @var \DateTime $veraendertam
     *
     * @ORM\Column(name="veraendertAm", type="datetime", nullable=false)
     */
    private $veraendertam;

    /**
     * @var boolean $bestaetigt
     *
     * @ORM\Column(name="bestaetigt", type="boolean", nullable=false)
     */
    private $bestaetigt;

    /**
     * @var anrede
     *
     * @ORM\ManyToOne(targetEntity="Anrede")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anrede_id", referencedColumnName="id")
     * })
     */
    private $anrede;

    /**
     * @var verein
     *
     * @ORM\ManyToOne(targetEntity="Verein")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="verein_id", referencedColumnName="id")
     * })
     */
    private $verein;
    
    /**
     * @ORM\ManyToMany(targetEntity="Liga", mappedBy="staffelleiter")
     */
    private $staffelleiter;
    
    /**
     * @ORM\OneToMany(targetEntity="MannschaftSpieler", mappedBy="spieler")
     */
    protected $mannschaftSpieler;
    
     /**
     * @ORM\OneToMany(targetEntity="Mannschaft", mappedBy="mannschaft")
     */
    protected $captainForMannschaften;


    public function __toString() {
        return trim($this->vorname . " " . $this->nachname);
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
     * @return Spieler
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
     * @return Spieler
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
     * Set strasse
     *
     * @param string $strasse
     * @return Spieler
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
     * Set lkz
     *
     * @param string $lkz
     * @return Spieler
     */
    public function setLkz($lkz)
    {
        $this->lkz = $lkz;
    
        return $this;
    }

    /**
     * Get lkz
     *
     * @return string 
     */
    public function getLkz()
    {
        return $this->lkz;
    }

    /**
     * Set plz
     *
     * @param string $plz
     * @return Spieler
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
     * @return Spieler
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
     * Set email
     *
     * @param string $email
     * @return Spieler
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
     * Set telefon
     *
     * @param string $telefon
     * @return Spieler
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
     * Set fax
     *
     * @param string $fax
     * @return Spieler
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set bild
     *
     * @param string $bild
     * @return Spieler
     */
    public function setBild($bild)
    {
        $this->bild = $bild;
    
        return $this;
    }

    /**
     * Get bild
     *
     * @return string 
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * Set nummerlizenz
     *
     * @param integer $nummerlizenz
     * @return Spieler
     */
    public function setNummerlizenz($nummerlizenz)
    {
        $this->nummerlizenz = $nummerlizenz;
    
        return $this;
    }

    /**
     * Get nummerlizenz
     *
     * @return integer 
     */
    public function getNummerlizenz()
    {
        return $this->nummerlizenz;
    }

    /**
     * Set trainer
     *
     * @param boolean $trainer
     * @return Spieler
     */
    public function setTrainer($trainer)
    {
        $this->trainer = $trainer;
    
        return $this;
    }

    /**
     * Get trainer
     *
     * @return boolean 
     */
    public function getTrainer()
    {
        return $this->trainer;
    }

    /**
     * Set schiedsrichter
     *
     * @param boolean $schiedsrichter
     * @return Spieler
     */
    public function setSchiedsrichter($schiedsrichter)
    {
        $this->schiedsrichter = $schiedsrichter;
    
        return $this;
    }

    /**
     * Get schiedsrichter
     *
     * @return boolean 
     */
    public function getSchiedsrichter()
    {
        return $this->schiedsrichter;
    }

    /**
     * Set veraendertam
     *
     * @param \DateTime $veraendertam
     * @return Spieler
     */
    public function setVeraendertam()
    {
        $this->veraendertam =  new \DateTime("now");
    
        return $this;
    }

    /**
     * Get veraendertam
     *
     * @return \DateTime 
     */
    public function getVeraendertam()
    {
        return $this->veraendertam;
    }

    /**
     * Set bestaetigt
     *
     * @param boolean $bestaetigt
     * @return Spieler
     */
    public function setBestaetigt($bestaetigt)
    {
        $this->bestaetigt = $bestaetigt;
    
        return $this;
    }

    /**
     * Get bestaetigt
     *
     * @return boolean 
     */
    public function getBestaetigt()
    {
        return $this->bestaetigt;
    }

    /**
     * Set veraendertvon
     *
     * @param Liganet\CoreBundle\Entity\Spieler $veraendertvon
     * @return Spieler
     */
    public function setVeraendertvon(\Liganet\CoreBundle\Entity\Spieler $veraendertvon = null)
    {
        $this->veraendertvon = $veraendertvon;
    
        return $this;
    }

    /**
     * Get veraendertvon
     *
     * @return Liganet\CoreBundle\Entity\Spieler 
     */
    public function getVeraendertvon()
    {
        return $this->veraendertvon;
    }

    /**
     * Set anrede
     *
     * @param Liganet\CoreBundle\Entity\Anrede $anrede
     * @return Spieler
     */
    public function setAnrede(\Liganet\CoreBundle\Entity\Anrede $anrede = null)
    {
        $this->anrede = $anrede;
    
        return $this;
    }

    /**
     * Get anrede
     *
     * @return Liganet\CoreBundle\Entity\Anrede 
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * Set verein
     *
     * @param Liganet\CoreBundle\Entity\Verein $verein
     * @return Spieler
     */
    public function setVerein(\Liganet\CoreBundle\Entity\Verein $verein = null)
    {
        $this->verein = $verein;
    
        return $this;
    }

    /**
     * Get verein
     *
     * @return Liganet\CoreBundle\Entity\Verein 
     */
    public function getVerein()
    {
        return $this->verein;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->staffelleiter = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Liga $staffelleiter
     * @return Spieler
     */
    public function addStaffelleiter(\Liganet\CoreBundle\Entity\Liga $staffelleiter)
    {
        $this->staffelleiter[] = $staffelleiter;
    
        return $this;
    }

    /**
     * Remove staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Liga $staffelleiter
     */
    public function removeStaffelleiter(\Liganet\CoreBundle\Entity\Liga $staffelleiter)
    {
        $this->staffelleiter->removeElement($staffelleiter);
    }

    /**
     * Get staffelleiter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStaffelleiter()
    {
        return $this->staffelleiter;
    }

    /**
     * Add mannschaften
     *
     * @param \Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaften
     * @return Spieler
     */
    public function addMannschaften(\Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaften)
    {
        $this->mannschaften[] = $mannschaften;
    
        return $this;
    }

    /**
     * Remove mannschaften
     *
     * @param \Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaften
     */
    public function removeMannschaften(\Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaften)
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
     * Add mannschaftSpieler
     *
     * @param \Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaftSpieler
     * @return Spieler
     */
    public function addMannschaftSpieler(\Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaftSpieler)
    {
        $this->mannschaftSpieler[] = $mannschaftSpieler;
    
        return $this;
    }

    /**
     * Remove mannschaftSpieler
     *
     * @param \Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaftSpieler
     */
    public function removeMannschaftSpieler(\Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaftSpieler)
    {
        $this->mannschaftSpieler->removeElement($mannschaftSpieler);
    }

    /**
     * Get mannschaftSpieler
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMannschaftSpieler()
    {
        return $this->mannschaftSpieler;
    }

    /**
     * Add captainForMannschaften
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $captainForMannschaften
     * @return Spieler
     */
    public function addCaptainForMannschaften(\Liganet\CoreBundle\Entity\Mannschaft $captainForMannschaften)
    {
        $this->captainForMannschaften[] = $captainForMannschaften;
    
        return $this;
    }

    /**
     * Remove captainForMannschaften
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $captainForMannschaften
     */
    public function removeCaptainForMannschaften(\Liganet\CoreBundle\Entity\Mannschaft $captainForMannschaften)
    {
        $this->captainForMannschaften->removeElement($captainForMannschaften);
    }

    /**
     * Get captainForMannschaften
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCaptainForMannschaften()
    {
        return $this->captainForMannschaften;
    }
}