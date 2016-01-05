<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="ln_ergebnis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Ergebnis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Begegnung", inversedBy="tags", cascade={"persist"})
     * @ORM\JoinColumn(name="begegnung_id", referencedColumnName="id")
     */
    protected $begegnung;
    
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
    
    
        
        
    public function __toString()
    {
        return $this->begegnung." ".$this->spielArt;
    }
    


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set task
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return Tag
     */
    public function setTask(\AppBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \AppBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set begegnung
     *
     * @param \AppBundle\Entity\Begegnung $begegnung
     *
     * @return Tag
     */
    public function setBegegnung(\AppBundle\Entity\Begegnung $begegnung = null)
    {
        $this->begegnung = $begegnung;

        return $this;
    }

    /**
     * Get begegnung
     *
     * @return \AppBundle\Entity\Begegnung
     */
    public function getBegegnung()
    {
        return $this->begegnung;
    }

    /**
     * Set kugeln1
     *
     * @param integer $kugeln1
     *
     * @return Tag
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
     *
     * @return Tag
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
     * Set platz
     *
     * @param integer $platz
     *
     * @return Tag
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
     * Set spielArt
     *
     * @param \AppBundle\Entity\SpielArt $spielArt
     *
     * @return Tag
     */
    public function setSpielArt(\AppBundle\Entity\SpielArt $spielArt = null)
    {
        $this->spielArt = $spielArt;

        return $this;
    }

    /**
     * Get spielArt
     *
     * @return \AppBundle\Entity\SpielArt
     */
    public function getSpielArt()
    {
        return $this->spielArt;
    }

    /**
     * Set spieler11
     *
     * @param \AppBundle\Entity\Spieler $spieler11
     *
     * @return Tag
     */
    public function setSpieler11(\AppBundle\Entity\Spieler $spieler11 = null)
    {
        $this->spieler1_1 = $spieler11;

        return $this;
    }

    /**
     * Get spieler11
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler11()
    {
        return $this->spieler1_1;
    }

    /**
     * Set spieler12
     *
     * @param \AppBundle\Entity\Spieler $spieler12
     *
     * @return Tag
     */
    public function setSpieler12(\AppBundle\Entity\Spieler $spieler12 = null)
    {
        $this->spieler1_2 = $spieler12;

        return $this;
    }

    /**
     * Get spieler12
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler12()
    {
        return $this->spieler1_2;
    }

    /**
     * Set spieler13
     *
     * @param \AppBundle\Entity\Spieler $spieler13
     *
     * @return Tag
     */
    public function setSpieler13(\AppBundle\Entity\Spieler $spieler13 = null)
    {
        $this->spieler1_3 = $spieler13;

        return $this;
    }

    /**
     * Get spieler13
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler13()
    {
        return $this->spieler1_3;
    }

    /**
     * Set spieler21
     *
     * @param \AppBundle\Entity\Spieler $spieler21
     *
     * @return Tag
     */
    public function setSpieler21(\AppBundle\Entity\Spieler $spieler21 = null)
    {
        $this->spieler2_1 = $spieler21;

        return $this;
    }

    /**
     * Get spieler21
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler21()
    {
        return $this->spieler2_1;
    }

    /**
     * Set spieler22
     *
     * @param \AppBundle\Entity\Spieler $spieler22
     *
     * @return Tag
     */
    public function setSpieler22(\AppBundle\Entity\Spieler $spieler22 = null)
    {
        $this->spieler2_2 = $spieler22;

        return $this;
    }

    /**
     * Get spieler22
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler22()
    {
        return $this->spieler2_2;
    }

    /**
     * Set spieler23
     *
     * @param \AppBundle\Entity\Spieler $spieler23
     *
     * @return Tag
     */
    public function setSpieler23(\AppBundle\Entity\Spieler $spieler23 = null)
    {
        $this->spieler2_3 = $spieler23;

        return $this;
    }

    /**
     * Get spieler23
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getSpieler23()
    {
        return $this->spieler2_3;
    }

    /**
     * Set ersatz1
     *
     * @param \AppBundle\Entity\Spieler $ersatz1
     *
     * @return Tag
     */
    public function setErsatz1(\AppBundle\Entity\Spieler $ersatz1 = null)
    {
        $this->ersatz1 = $ersatz1;

        return $this;
    }

    /**
     * Get ersatz1
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getErsatz1()
    {
        return $this->ersatz1;
    }

    /**
     * Set ersatzFuer1
     *
     * @param \AppBundle\Entity\Spieler $ersatzFuer1
     *
     * @return Tag
     */
    public function setErsatzFuer1(\AppBundle\Entity\Spieler $ersatzFuer1 = null)
    {
        $this->ersatzFuer1 = $ersatzFuer1;

        return $this;
    }

    /**
     * Get ersatzFuer1
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getErsatzFuer1()
    {
        return $this->ersatzFuer1;
    }

    /**
     * Set ersatz2
     *
     * @param \AppBundle\Entity\Spieler $ersatz2
     *
     * @return Tag
     */
    public function setErsatz2(\AppBundle\Entity\Spieler $ersatz2 = null)
    {
        $this->ersatz2 = $ersatz2;

        return $this;
    }

    /**
     * Get ersatz2
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getErsatz2()
    {
        return $this->ersatz2;
    }

    /**
     * Set ersatzFuer2
     *
     * @param \AppBundle\Entity\Spieler $ersatzFuer2
     *
     * @return Tag
     */
    public function setErsatzFuer2(\AppBundle\Entity\Spieler $ersatzFuer2 = null)
    {
        $this->ersatzFuer2 = $ersatzFuer2;

        return $this;
    }

    /**
     * Get ersatzFuer2
     *
     * @return \AppBundle\Entity\Spieler
     */
    public function getErsatzFuer2()
    {
        return $this->ersatzFuer2;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     *
     * @return Tag
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
}
