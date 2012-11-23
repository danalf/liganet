<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mannschaft
 *
 * @ORM\Table(name="ln_mannschaft")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\MannschaftRepository")
 */
class Mannschaft
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
     * @ORM\Column(name="rang", type="smallint")
     */
    private $rang;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text")
     */
    private $bemerkung;
    
    /**
     * @ORM\ManyToOne(targetEntity="Verein", inversedBy="mannschaften")
     * @ORM\JoinColumn(name="verein_id", referencedColumnName="id")
     */
    protected $verein;
    
    /**
     * @ORM\ManyToOne(targetEntity="LigaSaison", inversedBy="mannschaften")
     * @ORM\JoinColumn(name="liga_saison_id", referencedColumnName="id")
     */
    protected $ligasaison;
    
    /**
     * @ORM\OneToMany(targetEntity="MannschaftSpieler", mappedBy="mannschaft")
     */
    protected $mannschaftSpieler;


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
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return Mannschaft
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
     * Set verein
     *
     * @param \Liganet\CoreBundle\Entity\Verein $verein
     * @return Mannschaft
     */
    public function setVerein(\Liganet\CoreBundle\Entity\Verein $verein = null)
    {
        $this->verein = $verein;
    
        return $this;
    }

    /**
     * Get verein
     *
     * @return \Liganet\CoreBundle\Entity\Verein 
     */
    public function getVerein()
    {
        return $this->verein;
    }

    /**
     * Set ligasaison
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $ligasaison
     * @return Mannschaft
     */
    public function setLigasaison(\Liganet\CoreBundle\Entity\LigaSaison $ligasaison = null)
    {
        $this->ligasaison = $ligasaison;
    
        return $this;
    }

    /**
     * Get ligasaison
     *
     * @return \Liganet\CoreBundle\Entity\LigaSaison 
     */
    public function getLigasaison()
    {
        return $this->ligasaison;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     * @return Mannschaft
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }
    
    public function __toString() {
        $saison=(string) $this->ligasaison->getSaison()->getSaison();
        return $this->verein->getKuerzel().$this->rang." (".$saison.")";
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mannschaftSpieler = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mannschaftSpieler
     *
     * @param \Liganet\CoreBundle\Entity\MannschaftSpieler $mannschaftSpieler
     * @return Mannschaft
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
}