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
     * @ORM\ManyToOne(targetEntity="Verein", inversedBy="spieler")
     * @ORM\JoinColumn(name="verein_id", referencedColumnName="id")
     */
    private $verein;
    
    /**
     * @ORM\ManyToMany(targetEntity="LigaSaison", mappedBy="staffelleiter")
     */
    private $staffelleiter;
    
    /**
     * @ORM\ManyToMany(targetEntity="Verein", mappedBy="leiter")
     */
    private $vereinsleiter;
    
    /**
     * @ORM\ManyToMany(targetEntity="Region", mappedBy="leiter")
     */
    private $regionsleiter;
    
    /**
     * @ORM\OneToMany(targetEntity="MannschaftSpieler", mappedBy="spieler")
     */
    protected $mannschaftSpieler;
    
     /**
     * @ORM\OneToMany(targetEntity="Mannschaft", mappedBy="captain")
     */
    protected $captainForMannschaften;
    
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler1_1")
     */
    protected $spieler1_1;
    
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler1_2")
     */
    protected $spieler1_2;
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler1_3")
     */
    protected $spieler1_3;
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler2_1")
     */
    protected $spieler2_1;
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler2_2")
     */
    protected $spieler2_2;
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spieler2_3")
     */
    protected $spieler2_3;
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="ersatz1")
     */
    protected $ersatz1;
    
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="ersatzFuer1")
     */
    protected $ersatzFuer1;
    
    /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="ersatz2")
     */
    protected $ersatz2;
    
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="ersatzFuer2")
     */
    protected $ersatzFuer2;


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

    /**
     * Add spieler1_1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler11
     * @return Spieler
     */
    public function addSpieler11(\Liganet\CoreBundle\Entity\Ergebnis $spieler11)
    {
        $this->spieler1_1[] = $spieler11;
    
        return $this;
    }

    /**
     * Remove spieler1_1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler11
     */
    public function removeSpieler11(\Liganet\CoreBundle\Entity\Ergebnis $spieler11)
    {
        $this->spieler1_1->removeElement($spieler11);
    }

    /**
     * Get spieler1_1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler11()
    {
        return $this->spieler1_1;
    }

    /**
     * Add spieler1_2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler12
     * @return Spieler
     */
    public function addSpieler12(\Liganet\CoreBundle\Entity\Ergebnis $spieler12)
    {
        $this->spieler1_2[] = $spieler12;
    
        return $this;
    }

    /**
     * Remove spieler1_2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler12
     */
    public function removeSpieler12(\Liganet\CoreBundle\Entity\Ergebnis $spieler12)
    {
        $this->spieler1_2->removeElement($spieler12);
    }

    /**
     * Get spieler1_2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler12()
    {
        return $this->spieler1_2;
    }

    /**
     * Add spieler1_3
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler13
     * @return Spieler
     */
    public function addSpieler13(\Liganet\CoreBundle\Entity\Ergebnis $spieler13)
    {
        $this->spieler1_3[] = $spieler13;
    
        return $this;
    }

    /**
     * Remove spieler1_3
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler13
     */
    public function removeSpieler13(\Liganet\CoreBundle\Entity\Ergebnis $spieler13)
    {
        $this->spieler1_3->removeElement($spieler13);
    }

    /**
     * Get spieler1_3
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler13()
    {
        return $this->spieler1_3;
    }

    /**
     * Add spieler2_1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler21
     * @return Spieler
     */
    public function addSpieler21(\Liganet\CoreBundle\Entity\Ergebnis $spieler21)
    {
        $this->spieler2_1[] = $spieler21;
    
        return $this;
    }

    /**
     * Remove spieler2_1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler21
     */
    public function removeSpieler21(\Liganet\CoreBundle\Entity\Ergebnis $spieler21)
    {
        $this->spieler2_1->removeElement($spieler21);
    }

    /**
     * Get spieler2_1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler21()
    {
        return $this->spieler2_1;
    }

    /**
     * Add spieler2_2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler22
     * @return Spieler
     */
    public function addSpieler22(\Liganet\CoreBundle\Entity\Ergebnis $spieler22)
    {
        $this->spieler2_2[] = $spieler22;
    
        return $this;
    }

    /**
     * Remove spieler2_2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler22
     */
    public function removeSpieler22(\Liganet\CoreBundle\Entity\Ergebnis $spieler22)
    {
        $this->spieler2_2->removeElement($spieler22);
    }

    /**
     * Get spieler2_2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler22()
    {
        return $this->spieler2_2;
    }

    /**
     * Add spieler2_3
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler23
     * @return Spieler
     */
    public function addSpieler23(\Liganet\CoreBundle\Entity\Ergebnis $spieler23)
    {
        $this->spieler2_3[] = $spieler23;
    
        return $this;
    }

    /**
     * Remove spieler2_3
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $spieler23
     */
    public function removeSpieler23(\Liganet\CoreBundle\Entity\Ergebnis $spieler23)
    {
        $this->spieler2_3->removeElement($spieler23);
    }

    /**
     * Get spieler2_3
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieler23()
    {
        return $this->spieler2_3;
    }

    /**
     * Add ersatz1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatz1
     * @return Spieler
     */
    public function addErsatz1(\Liganet\CoreBundle\Entity\Ergebnis $ersatz1)
    {
        $this->ersatz1[] = $ersatz1;
    
        return $this;
    }

    /**
     * Remove ersatz1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatz1
     */
    public function removeErsatz1(\Liganet\CoreBundle\Entity\Ergebnis $ersatz1)
    {
        $this->ersatz1->removeElement($ersatz1);
    }

    /**
     * Get ersatz1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getErsatz1()
    {
        return $this->ersatz1;
    }

    /**
     * Add ersatzFuer1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer1
     * @return Spieler
     */
    public function addErsatzFuer1(\Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer1)
    {
        $this->ersatzFuer1[] = $ersatzFuer1;
    
        return $this;
    }

    /**
     * Remove ersatzFuer1
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer1
     */
    public function removeErsatzFuer1(\Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer1)
    {
        $this->ersatzFuer1->removeElement($ersatzFuer1);
    }

    /**
     * Get ersatzFuer1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getErsatzFuer1()
    {
        return $this->ersatzFuer1;
    }

    /**
     * Add ersatz2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatz2
     * @return Spieler
     */
    public function addErsatz2(\Liganet\CoreBundle\Entity\Ergebnis $ersatz2)
    {
        $this->ersatz2[] = $ersatz2;
    
        return $this;
    }

    /**
     * Remove ersatz2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatz2
     */
    public function removeErsatz2(\Liganet\CoreBundle\Entity\Ergebnis $ersatz2)
    {
        $this->ersatz2->removeElement($ersatz2);
    }

    /**
     * Get ersatz2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getErsatz2()
    {
        return $this->ersatz2;
    }

    /**
     * Add ersatzFuer2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer2
     * @return Spieler
     */
    public function addErsatzFuer2(\Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer2)
    {
        $this->ersatzFuer2[] = $ersatzFuer2;
    
        return $this;
    }

    /**
     * Remove ersatzFuer2
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer2
     */
    public function removeErsatzFuer2(\Liganet\CoreBundle\Entity\Ergebnis $ersatzFuer2)
    {
        $this->ersatzFuer2->removeElement($ersatzFuer2);
    }

    /**
     * Get ersatzFuer2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getErsatzFuer2()
    {
        return $this->ersatzFuer2;
    }

    /**
     * Add vereinsleiter
     *
     * @param \Liganet\CoreBundle\Entity\Verein $vereinsleiter
     * @return Spieler
     */
    public function addVereinsleiter(\Liganet\CoreBundle\Entity\Verein $vereinsleiter)
    {
        $this->vereinsleiter[] = $vereinsleiter;
    
        return $this;
    }

    /**
     * Remove vereinsleiter
     *
     * @param \Liganet\CoreBundle\Entity\Verein $vereinsleiter
     */
    public function removeVereinsleiter(\Liganet\CoreBundle\Entity\Verein $vereinsleiter)
    {
        $this->vereinsleiter->removeElement($vereinsleiter);
    }

    /**
     * Get vereinsleiter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVereinsleiter()
    {
        return $this->vereinsleiter;
    }

    /**
     * Add regionsleiter
     *
     * @param \Liganet\CoreBundle\Entity\Region $regionsleiter
     * @return Spieler
     */
    public function addRegionsleiter(\Liganet\CoreBundle\Entity\Region $regionsleiter)
    {
        $this->regionsleiter[] = $regionsleiter;
    
        return $this;
    }

    /**
     * Remove regionsleiter
     *
     * @param \Liganet\CoreBundle\Entity\Region $regionsleiter
     */
    public function removeRegionsleiter(\Liganet\CoreBundle\Entity\Region $regionsleiter)
    {
        $this->regionsleiter->removeElement($regionsleiter);
    }

    /**
     * Get regionsleiter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegionsleiter()
    {
        return $this->regionsleiter;
    }
    
    public function getNameWithLizenz(){
        return $this->getNummerlizenz()." ".trim($this->getVorname()." ".$this->getNachname());
    }
}