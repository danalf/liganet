<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Begegnung
 *
 * @ORM\Table("ln_begegnung")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\BegegnungRepository")
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
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="begegnung")
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
     * @ORM\Column(name="unterschrift1", type="boolean")
     */
    private $unterschrift1=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschrift2", type="boolean")
     */
    private $unterschrift2=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschriftLeiter", type="boolean")
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
        $this->ergebnisse = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ergebnisse
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ergebnisse
     * @return Begegnung
     */
    public function addErgebnisse(\Liganet\CoreBundle\Entity\Ergebnis $ergebnisse)
    {
        $this->ergebnisse[] = $ergebnisse;
    
        return $this;
    }

    /**
     * Remove ergebnisse
     *
     * @param \Liganet\CoreBundle\Entity\Ergebnis $ergebnisse
     */
    public function removeErgebnisse(\Liganet\CoreBundle\Entity\Ergebnis $ergebnisse)
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
     * @param \Liganet\CoreBundle\Entity\SpielRunde $spielRunde
     * @return Begegnung
     */
    public function setSpielRunde(\Liganet\CoreBundle\Entity\SpielRunde $spielRunde = null)
    {
        $this->spielRunde = $spielRunde;
    
        return $this;
    }

    /**
     * Get spielRunde
     *
     * @return \Liganet\CoreBundle\Entity\SpielRunde 
     */
    public function getSpielRunde()
    {
        return $this->spielRunde;
    }

    /**
     * Set mannschaft1
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $mannschaft1
     * @return Begegnung
     */
    public function setMannschaft1(\Liganet\CoreBundle\Entity\Mannschaft $mannschaft1 = null)
    {
        $this->mannschaft1 = $mannschaft1;
    
        return $this;
    }

    /**
     * Get mannschaft1
     *
     * @return \Liganet\CoreBundle\Entity\Mannschaft 
     */
    public function getMannschaft1()
    {
        return $this->mannschaft1;
    }

    /**
     * Set mannschaft2
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $mannschaft2
     * @return Begegnung
     */
    public function setMannschaft2(\Liganet\CoreBundle\Entity\Mannschaft $mannschaft2 = null)
    {
        $this->mannschaft2 = $mannschaft2;
    
        return $this;
    }

    /**
     * Get mannschaft2
     *
     * @return \Liganet\CoreBundle\Entity\Mannschaft 
     */
    public function getMannschaft2()
    {
        return $this->mannschaft2;
    }
}