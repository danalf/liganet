<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ergebnis
 *
 * @ORM\Table("ln_ergebnis")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\ErgebnisRepository")
 */
class Ergebnis
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
     * @ORM\ManyToOne(targetEntity="Begegnung", inversedBy="ergebnisse")
     * @ORM\JoinColumn(name="begegnung_id", referencedColumnName="id")
     */
    protected $begegnung;
    
    /**
     * @ORM\ManyToOne(targetEntity="SpielArt", inversedBy="ergebnisse")
     * @ORM\JoinColumn(name="spielArt_id", referencedColumnName="id")
     */
    protected $spielArt;

    /**
     * @var integer
     *
     * @ORM\Column(name="platz", type="smallint")
     */
    private $platz;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text", nullable=true)
     */
    private $bemerkung;

    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler1_1")
     * @ORM\JoinColumn(name="spieler1_1", referencedColumnName="id")
     */
    protected $spieler1_1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler1_2")
     * @ORM\JoinColumn(name="spieler1_2", referencedColumnName="id")
     */
    protected $spieler1_2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler1_3")
     * @ORM\JoinColumn(name="spieler1_3", referencedColumnName="id")
     */
    protected $spieler1_3;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler2_1")
     * @ORM\JoinColumn(name="spieler2_1", referencedColumnName="id")
     */
    protected $spieler2_1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler2_2")
     * @ORM\JoinColumn(name="spieler2_2", referencedColumnName="id")
     */
    protected $spieler2_2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="spieler2_3")
     * @ORM\JoinColumn(name="spieler2_3", referencedColumnName="id")
     */
    protected $spieler2_3;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="ersatz1")
     * @ORM\JoinColumn(name="ersatz1", referencedColumnName="id")
     */
    protected $ersatz1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="ersatzFuer1")
     * @ORM\JoinColumn(name="ersatzFuer1", referencedColumnName="id")
     */
    protected $ersatzFuer1;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="ersatz2")
     * @ORM\JoinColumn(name="ersatz2", referencedColumnName="id")
     */
    protected $ersatz2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="ersatzFuer2")
     * @ORM\JoinColumn(name="ersatzFuer2", referencedColumnName="id")
     */
    protected $ersatzFuer2;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set platz
     *
     * @param integer $platz
     * @return Ergebnis
     */
    public function setPlatz($platz)
    {
        $this->platz = $platz;
    
        return $this;
    }

    /**
     * Get platz
     *
     * @return integer 
     */
    public function getPlatz()
    {
        return $this->platz;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return Ergebnis
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
     * Set unterschrift_ligaleiter
     *
     * @param boolean $unterschriftLigaleiter
     * @return Ergebnis
     */
    public function setUnterschriftLigaleiter($unterschriftLigaleiter)
    {
        $this->unterschrift_ligaleiter = $unterschriftLigaleiter;
    
        return $this;
    }

    /**
     * Get unterschrift_ligaleiter
     *
     * @return boolean 
     */
    public function getUnterschriftLigaleiter()
    {
        return $this->unterschrift_ligaleiter;
    }

    /**
     * Set kugeln1
     *
     * @param integer $kugeln1
     * @return Ergebnis
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
     * @return Ergebnis
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
     * Set begegnung
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnung
     * @return Ergebnis
     */
    public function setBegegnung(\Liganet\CoreBundle\Entity\Begegnung $begegnung = null)
    {
        $this->begegnung = $begegnung;
    
        return $this;
    }

    /**
     * Get begegnung
     *
     * @return \Liganet\CoreBundle\Entity\Begegnung 
     */
    public function getBegegnung()
    {
        return $this->begegnung;
    }

    /**
     * Set spielArt
     *
     * @param \Liganet\CoreBundle\Entity\SpielArt $spielArt
     * @return Ergebnis
     */
    public function setSpielArt(\Liganet\CoreBundle\Entity\SpielArt $spielArt = null)
    {
        $this->spielArt = $spielArt;
    
        return $this;
    }

    /**
     * Get spielArt
     *
     * @return \Liganet\CoreBundle\Entity\SpielArt 
     */
    public function getSpielArt()
    {
        return $this->spielArt;
    }

    /**
     * Set spieler1_1
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler11
     * @return Ergebnis
     */
    public function setSpieler11(\Liganet\CoreBundle\Entity\Spieler $spieler11 = null)
    {
        $this->spieler1_1 = $spieler11;
    
        return $this;
    }

    /**
     * Get spieler1_1
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler11()
    {
        return $this->spieler1_1;
    }

    /**
     * Set spieler1_2
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler12
     * @return Ergebnis
     */
    public function setSpieler12(\Liganet\CoreBundle\Entity\Spieler $spieler12 = null)
    {
        $this->spieler1_2 = $spieler12;
    
        return $this;
    }

    /**
     * Get spieler1_2
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler12()
    {
        return $this->spieler1_2;
    }

    /**
     * Set spieler1_3
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler13
     * @return Ergebnis
     */
    public function setSpieler13(\Liganet\CoreBundle\Entity\Spieler $spieler13 = null)
    {
        $this->spieler1_3 = $spieler13;
    
        return $this;
    }

    /**
     * Get spieler1_3
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler13()
    {
        return $this->spieler1_3;
    }

    /**
     * Set spieler2_1
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler21
     * @return Ergebnis
     */
    public function setSpieler21(\Liganet\CoreBundle\Entity\Spieler $spieler21 = null)
    {
        $this->spieler2_1 = $spieler21;
    
        return $this;
    }

    /**
     * Get spieler2_1
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler21()
    {
        return $this->spieler2_1;
    }

    /**
     * Set spieler2_2
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler22
     * @return Ergebnis
     */
    public function setSpieler22(\Liganet\CoreBundle\Entity\Spieler $spieler22 = null)
    {
        $this->spieler2_2 = $spieler22;
    
        return $this;
    }

    /**
     * Get spieler2_2
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler22()
    {
        return $this->spieler2_2;
    }

    /**
     * Set spieler2_3
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $spieler23
     * @return Ergebnis
     */
    public function setSpieler23(\Liganet\CoreBundle\Entity\Spieler $spieler23 = null)
    {
        $this->spieler2_3 = $spieler23;
    
        return $this;
    }

    /**
     * Get spieler2_3
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler23()
    {
        return $this->spieler2_3;
    }

    /**
     * Set ersatz1
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $ersatz1
     * @return Ergebnis
     */
    public function setErsatz1(\Liganet\CoreBundle\Entity\Spieler $ersatz1 = null)
    {
        $this->ersatz1 = $ersatz1;
    
        return $this;
    }

    /**
     * Get ersatz1
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getErsatz1()
    {
        return $this->ersatz1;
    }

    /**
     * Set ersatzFuer1
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $ersatzFuer1
     * @return Ergebnis
     */
    public function setErsatzFuer1(\Liganet\CoreBundle\Entity\Spieler $ersatzFuer1 = null)
    {
        $this->ersatzFuer1 = $ersatzFuer1;
    
        return $this;
    }

    /**
     * Get ersatzFuer1
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getErsatzFuer1()
    {
        return $this->ersatzFuer1;
    }

    /**
     * Set ersatz2
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $ersatz2
     * @return Ergebnis
     */
    public function setErsatz2(\Liganet\CoreBundle\Entity\Spieler $ersatz2 = null)
    {
        $this->ersatz2 = $ersatz2;
    
        return $this;
    }

    /**
     * Get ersatz2
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getErsatz2()
    {
        return $this->ersatz2;
    }

    /**
     * Set ersatzFuer2
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $ersatzFuer2
     * @return Ergebnis
     */
    public function setErsatzFuer2(\Liganet\CoreBundle\Entity\Spieler $ersatzFuer2 = null)
    {
        $this->ersatzFuer2 = $ersatzFuer2;
    
        return $this;
    }

    /**
     * Get ersatzFuer2
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getErsatzFuer2()
    {
        return $this->ersatzFuer2;
    }
}