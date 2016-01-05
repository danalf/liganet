<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Begegnung
 *
 * @ORM\Table("ln_begegnung")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BegegnungRepository")
 */
class Begegnung
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="begegnung", cascade={"persist"})
     */
    protected $ergebnisse;
    
    /**
     * @ORM\ManyToOne(targetEntity="SpielRunde", inversedBy="begegnungen")
     * @ORM\JoinColumn(name="spielrunde_id", referencedColumnName="id")
     */
    protected $spielRunde;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mannschaft", inversedBy="begegnungen1")
     * @ORM\JoinColumn(name="mannschaft1_id", referencedColumnName="id")
     */
    protected $mannschaft1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mannschaft", inversedBy="begegnungen2")
     * @ORM\JoinColumn(name="mannschaft2_id", referencedColumnName="id")
     */
    protected $mannschaft2;

    /**
     * @var integer
     *
     * @ORM\Column(name="kugeln1", type="smallint")
     */
    private $kugeln1=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="kugeln2", type="smallint")
     */
    private $kugeln2=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="siege1", type="smallint")
     */
    private $siege1=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="siege2", type="smallint")
     */
    private $siege2=0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="punkt1", type="boolean")
     */
    private $punkt1=0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="punkt2", type="boolean")
     */
    private $punkt2=0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschrift1", type="boolean", nullable=true)
     */
    private $unterschrift1=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschrift2", type="boolean", nullable=true)
     */
    private $unterschrift2=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschriftLeiter", type="boolean", nullable=true)
     */
    private $unterschriftLeiter=false;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text", nullable=true)
     */
    private $bemerkung;


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
     * Set kugeln1
     *
     * @param integer $kugeln1
     * @return Begegnung
     */
    public function setKugeln1($kugeln1)
    {
        $this->kugeln1 = $kugeln1;
    
        return $this;
    }

    /**
     * Get kugeln1
     *
     * @return integer 
     */
    public function getKugeln1()
    {
        return $this->kugeln1;
    }

    /**
     * Set kugeln2
     *
     * @param integer $kugeln2
     * @return Begegnung
     */
    public function setKugeln2($kugeln2)
    {
        $this->kugeln2 = $kugeln2;
    
        return $this;
    }

    /**
     * Get kugeln2
     *
     * @return integer 
     */
    public function getKugeln2()
    {
        return $this->kugeln2;
    }

    /**
     * Set siege1
     *
     * @param integer $siege1
     * @return Begegnung
     */
    public function setSiege1($siege1)
    {
        $this->siege1 = $siege1;
    
        return $this;
    }

    /**
     * Get siege1
     *
     * @return integer 
     */
    public function getSiege1()
    {
        return $this->siege1;
    }

    /**
     * Set siege2
     *
     * @param integer $siege2
     * @return Begegnung
     */
    public function setSiege2($siege2)
    {
        $this->siege2 = $siege2;
    
        return $this;
    }

    /**
     * Get siege2
     *
     * @return integer 
     */
    public function getSiege2()
    {
        return $this->siege2;
    }

    /**
     * Set punkt1
     *
     * @param boolean $punkt1
     * @return Begegnung
     */
    public function setPunkt1($punkt1)
    {
        $this->punkt1 = $punkt1;
    
        return $this;
    }

    /**
     * Get punkt1
     *
     * @return boolean 
     */
    public function getPunkt1()
    {
        return $this->punkt1;
    }

    /**
     * Set punkt2
     *
     * @param boolean $punkt2
     * @return Begegnung
     */
    public function setPunkt2($punkt2)
    {
        $this->punkt2 = $punkt2;
    
        return $this;
    }

    /**
     * Get punkt2
     *
     * @return boolean 
     */
    public function getPunkt2()
    {
        return $this->punkt2;
    }

    /**
     * Set unterschrift1
     *
     * @param boolean $unterschrift1
     * @return Begegnung
     */
    public function setUnterschrift1($unterschrift1)
    {
        $this->unterschrift1 = $unterschrift1;
    
        return $this;
    }

    /**
     * Get unterschrift1
     *
     * @return boolean 
     */
    public function getUnterschrift1()
    {
        return $this->unterschrift1;
    }

    /**
     * Set unterschrift2
     *
     * @param boolean $unterschrift2
     * @return Begegnung
     */
    public function setUnterschrift2($unterschrift2)
    {
        $this->unterschrift2 = $unterschrift2;
    
        return $this;
    }

    /**
     * Get unterschrift2
     *
     * @return boolean 
     */
    public function getUnterschrift2()
    {
        return $this->unterschrift2;
    }

    /**
     * Set unterschriftLeiter
     *
     * @param boolean $unterschriftLeiter
     * @return Begegnung
     */
    public function setUnterschriftLeiter($unterschriftLeiter)
    {
        $this->unterschriftLeiter = $unterschriftLeiter;
    
        return $this;
    }

    /**
     * Get unterschriftLeiter
     *
     * @return boolean 
     */
    public function getUnterschriftLeiter()
    {
        return $this->unterschriftLeiter;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return Begegnung
     */
    public function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
    
        return $this;
    }

    /**
     * Get bemerkung
     *
     * @return string 
     */
    public function getBemerkung()
    {
        return $this->bemerkung;
    }
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ergebnisse = new ArrayCollection();
    }
     
    /**
     * Add ergebnisse
     *
     * @param \AppBundle\Entity\Ergebnis $ergebnisse
     * @return Begegnung
     */
    public function addErgebnisse(\AppBundle\Entity\Ergebnis $ergebnisse)
    {
        $this->ergebnisse[] = $ergebnisse;
    
        return $this;
    }

    /**
     * Remove ergebnisse
     *
     * @param \AppBundle\Entity\Ergebnis $ergebnisse
     */
    public function removeErgebnisse(\AppBundle\Entity\Ergebnis $ergebnisse)
    {
        $this->ergebnisse->removeElement($ergebnisse);
    }

    /**
     * Get ergebnisse
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getErgebnisse()
    {
        return $this->ergebnisse;
    }

    /**
     * Set spielRunde
     *
     * @param \AppBundle\Entity\SpielRunde $spielRunde
     * @return Begegnung
     */
    public function setSpielRunde(\AppBundle\Entity\SpielRunde $spielRunde = null)
    {
        $this->spielRunde = $spielRunde;
    
        return $this;
    }

    /**
     * Get spielRunde
     *
     * @return \AppBundle\Entity\SpielRunde 
     */
    public function getSpielRunde()
    {
        return $this->spielRunde;
    }

    /**
     * Set mannschaft1
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaft1
     * @return Begegnung
     */
    public function setMannschaft1(\AppBundle\Entity\Mannschaft $mannschaft1 = null)
    {
        $this->mannschaft1 = $mannschaft1;
    
        return $this;
    }

    /**
     * Get mannschaft1
     *
     * @return \AppBundle\Entity\Mannschaft 
     */
    public function getMannschaft1()
    {
        return $this->mannschaft1;
    }

    /**
     * Set mannschaft2
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaft2
     * @return Begegnung
     */
    public function setMannschaft2(\AppBundle\Entity\Mannschaft $mannschaft2 = null)
    {
        $this->mannschaft2 = $mannschaft2;
    
        return $this;
    }

    /**
     * Get mannschaft2
     *
     * @return \AppBundle\Entity\Mannschaft 
     */
    public function getMannschaft2()
    {
        return $this->mannschaft2;
    }
    
    public function __toString() {
        return $this->getSpielRunde()." ".$this->getMannschaft1()->getNameKurz()." : ".$this->getMannschaft2()->getNameKurz();
    }
    
    /**
     * Fügt dem übergebenen Objekt Tabelle die Werte der Begegnung zu
     * 
     * Gibt 1 zurück, wenn mannschaft 1 der gesuchten Mannschaft entpricht
     * Gibt 2 zurück, wenn mannschaft 2 der gesuchten Mannschaft entpricht
     * Gibt 0, bzw. FALSE zurück, wenn die gesuchte Mannschaft nicht an der begegnung teilgenommen hat
     * @param Mannschaft $mannschaft
     * @return integer 
     */
    public function addToTable(Tabelle &$tabelle) {
        $idMannschaft = $tabelle->getMannschaft()->getId();
        if ($idMannschaft == $this->getMannschaft1()->getId()) {
            $kugeln1=$tabelle->getKugeln1()+$this->kugeln1;
            $tabelle->setKugeln1($kugeln1);
            $kugeln2=$tabelle->getKugeln2()+$this->kugeln2;
            $tabelle->setKugeln2($kugeln2);
            $spiele1=$tabelle->getSpiele1()+$this->siege1;
            $tabelle->setSpiele1($spiele1);
            $spiele2=$tabelle->getSpiele2()+$this->siege2;
            $tabelle->setSpiele2($spiele2);
            $punkte1=$tabelle->getPunkte1()+$this->punkt1;
            $tabelle->setPunkte1($punkte1);
            $punkte2=$tabelle->getPunkte2()+$this->punkt2;
            $tabelle->setPunkte2($punkte2);
            $tabelle->setDifferenz($tabelle->getKugeln1()-$tabelle->getKugeln2());
            $debug = 1;
        }
        if ($idMannschaft == $this->getMannschaft2()->getId()) {
            $kugeln1=$tabelle->getKugeln1()+$this->kugeln2;
            $tabelle->setKugeln1($kugeln1);
            $kugeln2=$tabelle->getKugeln2()+$this->kugeln1;
            $tabelle->setKugeln2($kugeln2);
            $spiele1=$tabelle->getSpiele1()+$this->siege2;
            $tabelle->setSpiele1($spiele1);
            $spiele2=$tabelle->getSpiele2()+$this->siege1;
            $tabelle->setSpiele2($spiele2);
            $punkte1=$tabelle->getPunkte1()+$this->punkt2;
            $tabelle->setPunkte1($punkte1);
            $punkte2=$tabelle->getPunkte2()+$this->punkt1;
            $tabelle->setPunkte2($punkte2);
            $tabelle->setDifferenz($tabelle->getKugeln1()-$tabelle->getKugeln2());
            $debug = 2;
        }
        if (!isset($debug)) {
            $debug = 0;
        }
        //echo $idMannschaft." ".$this->mannschaft1." ".$this->mannschaft2." $debug"."<br/>";
        return $debug;
    }
    
    public function setErgebnisse(){
        $this->setKugeln1(0);
         $this->setKugeln2(0);
         $this->setSiege1(0);
         $this->setSiege2(0);
         $this->setPunkt1(0);
         $this->setPunkt2(0);
        foreach ($this->getErgebnisse() as $ergebnis) {
            /* @var $ergebnis \AppBundle\Entity\Ergebnis  */
            $this->setKugeln1($ergebnis->getKugeln1()+$this->getKugeln1());
            $this->setKugeln2($ergebnis->getKugeln2()+$this->getKugeln2());
            if($ergebnis->getKugeln1()>$ergebnis->getKugeln2()) {
                $this->setSiege1($this->getSiege1()+1);
            }
            if($ergebnis->getKugeln2()>$ergebnis->getKugeln1()) {
                $this->setSiege2($this->getSiege2()+1);
            }
        }
        if($this->getSiege1()>$this->getSiege2()) 
            $this->setPunkt1(1);
        if($this->getSiege2()>$this->getSiege1()) 
            $this->setPunkt2(1);
    }
}
