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
     * @ORM\Column(name="bemerkung", type="text", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="captainForMannschaften")
     * @ORM\JoinColumn(name="captain_id", referencedColumnName="id", nullable=true)
     */
    protected $captain;
    
    /**
     * @ORM\OneToMany(targetEntity="Begegnung", mappedBy="mannschaft1")
     */
    protected $begegnungen1;
    
    /**
     * @ORM\OneToMany(targetEntity="Begegnung", mappedBy="mannschaft2")
     */
    protected $begegnungen2;


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

    /**
     * Set captain
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $captain
     * @return Mannschaft
     */
    public function setCaptain(\Liganet\CoreBundle\Entity\Spieler $captain = null)
    {
        $this->captain = $captain;
    
        return $this;
    }

    /**
     * Get captain
     *
     * @return \Liganet\CoreBundle\Entity\Spieler 
     */
    public function getCaptain()
    {
        return $this->captain;
    }

    /**
     * Add begegnungen1
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen1
     * @return Mannschaft
     */
    public function addBegegnungen1(\Liganet\CoreBundle\Entity\Begegnung $begegnungen1)
    {
        $this->begegnungen1[] = $begegnungen1;
    
        return $this;
    }

    /**
     * Remove begegnungen1
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen1
     */
    public function removeBegegnungen1(\Liganet\CoreBundle\Entity\Begegnung $begegnungen1)
    {
        $this->begegnungen1->removeElement($begegnungen1);
    }

    /**
     * Get begegnungen1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBegegnungen1()
    {
        return $this->begegnungen1;
    }

    /**
     * Add begegnungen2
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen2
     * @return Mannschaft
     */
    public function addBegegnungen2(\Liganet\CoreBundle\Entity\Begegnung $begegnungen2)
    {
        $this->begegnungen2[] = $begegnungen2;
    
        return $this;
    }

    /**
     * Remove begegnungen2
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen2
     */
    public function removeBegegnungen2(\Liganet\CoreBundle\Entity\Begegnung $begegnungen2)
    {
        $this->begegnungen2->removeElement($begegnungen2);
    }

    /**
     * Get begegnungen2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBegegnungen2()
    {
        return $this->begegnungen2;
    }
}