<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Spieltag
 *
 * @ORM\Table(name="ln_spieltag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpieltagRepository")
 */
class Spieltag
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
     * @var integer
     *
     * @ORM\Column(name="nummer", type="smallint")
     */
    private $nummer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum", type="datetime")
     */
    private $datum;
    
    /**
     * @ORM\ManyToOne(targetEntity="LigaSaison", inversedBy="spieltage")
     * @ORM\JoinColumn(name="liga_saison_id", referencedColumnName="id")
     */
    protected $ligasaison;
    
    /**
     * @ORM\ManyToOne(targetEntity="Verein", inversedBy="ausgerichteterSpieltag")
     * @ORM\JoinColumn(name="verein_id", referencedColumnName="id", nullable=true)
     */
    protected $austragenderVerein;
    
    /**
     * @ORM\OneToMany(targetEntity="SpielRunde", mappedBy="spieltag")
     */
    protected $runden;


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
     * Set nummer
     *
     * @param integer $nummer
     * @return Spieltag
     */
    public function setNummer($nummer)
    {
        $this->nummer = $nummer;
    
        return $this;
    }

    /**
     * Get nummer
     *
     * @return integer 
     */
    public function getNummer()
    {
        return $this->nummer;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     * @return Spieltag
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    
        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime 
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set austragenderVerein
     *
     * @param string $austragenderVerein
     * @return Spieltag
     */
    public function setAustragenderVerein($austragenderVerein)
    {
        $this->austragenderVerein = $austragenderVerein;
    
        return $this;
    }

    /**
     * Get austragenderVerein
     *
     * @return string 
     */
    public function getAustragenderVerein()
    {
        return $this->austragenderVerein;
    }

    /**
     * Set ligasaison
     *
     * @param \AppBundle\Entity\LigaSaison $ligasaison
     * @return Spieltag
     */
    public function setLigasaison(\AppBundle\Entity\LigaSaison $ligasaison = null)
    {
        $this->ligasaison = $ligasaison;
    
        return $this;
    }

    /**
     * Get ligasaison
     *
     * @return \AppBundle\Entity\LigaSaison 
     */
    public function getLigasaison()
    {
        return $this->ligasaison;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->runden = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add runden
     *
     * @param \AppBundle\Entity\Spielrunde $runden
     * @return Spieltag
     */
    public function addRunden(\AppBundle\Entity\Spielrunde $runden)
    {
        $this->runden[] = $runden;
    
        return $this;
    }

    /**
     * Remove runden
     *
     * @param \AppBundle\Entity\Spielrunde $runden
     */
    public function removeRunden(\AppBundle\Entity\Spielrunde $runden)
    {
        $this->runden->removeElement($runden);
    }

    /**
     * Get runden
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRunden()
    {
        return $this->runden;
    }
    
    public function __toString() {
        return $this->getLigasaison()." " . $this->getNummer();
    }
}
