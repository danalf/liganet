<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpielArt
 *
 * @ORM\Table("ln_spiel_art")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpielArtRepository")
 */
class SpielArt
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nameKurz", type="string", length=10)
     */
    private $nameKurz;

    /**
     * @var integer
     *
     * @ORM\Column(name="anzahlSpieler", type="smallint")
     */
    private $anzahlSpieler;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mixte", type="boolean", nullable=true)
     */
    private $mixte;

    /**
     * @var integer
     *
     * @ORM\Column(name="nummer", type="smallint")
     */
    private $nummer;

    /**
     * @var integer
     *
     * @ORM\Column(name="reihenfolge", type="smallint")
     */
    private $reihenfolge;
    
    /**
     * @ORM\ManyToOne(targetEntity="Modus", inversedBy="spielArt")
     * @ORM\JoinColumn(name="modus_id", referencedColumnName="id")
     */
    protected $modus;
    
     /**
     * @ORM\OneToMany(targetEntity="Ergebnis", mappedBy="spielArt")
     */
    protected $ergebnisse;



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
     * Set name
     *
     * @param string $name
     * @return SpielArt
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
     * Set nameKurz
     *
     * @param string $nameKurz
     * @return SpielArt
     */
    public function setNameKurz($nameKurz)
    {
        $this->nameKurz = $nameKurz;
    
        return $this;
    }

    /**
     * Get nameKurz
     *
     * @return string 
     */
    public function getNameKurz()
    {
        return $this->nameKurz;
    }

    /**
     * Set anzahlSpieler
     *
     * @param integer $anzahlSpieler
     * @return SpielArt
     */
    public function setAnzahlSpieler($anzahlSpieler)
    {
        $this->anzahlSpieler = $anzahlSpieler;
    
        return $this;
    }

    /**
     * Get anzahlSpieler
     *
     * @return integer 
     */
    public function getAnzahlSpieler()
    {
        return $this->anzahlSpieler;
    }

    /**
     * Set mixte
     *
     * @param boolean $mixte
     * @return SpielArt
     */
    public function setMixte($mixte)
    {
        $this->mixte = $mixte;
    
        return $this;
    }

    /**
     * Get mixte
     *
     * @return boolean 
     */
    public function getMixte()
    {
        return $this->mixte;
    }

    /**
     * Set nummer
     *
     * @param integer $nummer
     * @return SpielArt
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
     * Set reihenfolge
     *
     * @param integer $reihenfolge
     * @return SpielArt
     */
    public function setReihenfolge($reihenfolge)
    {
        $this->reihenfolge = $reihenfolge;
    
        return $this;
    }

    /**
     * Get reihenfolge
     *
     * @return integer 
     */
    public function getReihenfolge()
    {
        return $this->reihenfolge;
    }

    /**
     * Set modus
     *
     * @param \AppBundle\Entity\Modus $modus
     * @return SpielArt
     */
    public function setModus(\AppBundle\Entity\Modus $modus = null)
    {
        $this->modus = $modus;
    
        return $this;
    }

    /**
     * Get modus
     *
     * @return \AppBundle\Entity\Modus 
     */
    public function getModus()
    {
        return $this->modus;
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
     * @param \AppBundle\Entity\Ergebnis $ergebnisse
     * @return SpielArt
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
    
    public function __toString() {
       return $this->getName();
    }
}
