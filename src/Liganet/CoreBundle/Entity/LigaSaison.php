<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigaSaison
 *
 * @ORM\Table(name="ln_liga_saison")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\LigaSaisonRepository")
 */
class LigaSaison
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
     * @var boolean
     *
     * @ORM\Column(name="gesperrt", type="boolean", nullable=true)
     */
    private $gesperrt;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="actual", type="boolean", nullable=true)
     */
    private $actual;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text", nullable=true)
     */
    private $bemerkung;
    
    /**
     * @ORM\ManyToOne(targetEntity="Saison", inversedBy="liga_saison")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    protected $saison;
    
    /**
     * @ORM\ManyToOne(targetEntity="Liga", inversedBy="liga_saison")
     * @ORM\JoinColumn(name="liga_id", referencedColumnName="id")
     */
    protected $liga;
    
    /**
     * @ORM\OneToMany(targetEntity="Mannschaft", mappedBy="ligasaison")
     */
    protected $mannschaften;
    
    /**
     * @ORM\OneToMany(targetEntity="Spieltag", mappedBy="ligasaison")
     */
    protected $spieltage;
    
    /**
     * @ORM\ManyToMany(targetEntity="Spieler", inversedBy="staffelleiter")
     * @ORM\JoinTable(name="ln_spieler_staffelleiter")
     */
    private $staffelleiter;


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
     * Set gesperrt
     *
     * @param boolean $gesperrt
     * @return LigaSaison
     */
    public function setGesperrt($gesperrt)
    {
        $this->gesperrt = $gesperrt;
    
        return $this;
    }

    /**
     * Get gesperrt
     *
     * @return boolean 
     */
    public function getGesperrt()
    {
        return $this->gesperrt;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return LigaSaison
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
     * Set saison
     *
     * @param \Liganet\CoreBundle\Entity\Saison $saison
     * @return LigaSaison
     */
    public function setSaison(\Liganet\CoreBundle\Entity\Saison $saison = null)
    {
        $this->saison = $saison;
    
        return $this;
    }

    /**
     * Get saison
     *
     * @return \Liganet\CoreBundle\Entity\Saison 
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set liga
     *
     * @param \Liganet\CoreBundle\Entity\Liga $liga
     * @return LigaSaison
     */
    public function setLiga(\Liganet\CoreBundle\Entity\Liga $liga = null)
    {
        $this->liga = $liga;
    
        return $this;
    }

    /**
     * Get liga
     *
     * @return \Liganet\CoreBundle\Entity\Liga 
     */
    public function getLiga()
    {
        return $this->liga;
    }
    
    public function __toString() {
        return $this->liga->getName()." ".$this->liga->getRegion()->getNameKurz()." ".$this->saison->getSaison();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mannschaften = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mannschaften
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $mannschaften
     * @return LigaSaison
     */
    public function addMannschaften(\Liganet\CoreBundle\Entity\Mannschaft $mannschaften)
    {
        $this->mannschaften[] = $mannschaften;
    
        return $this;
    }

    /**
     * Remove mannschaften
     *
     * @param \Liganet\CoreBundle\Entity\Mannschaft $mannschaften
     */
    public function removeMannschaften(\Liganet\CoreBundle\Entity\Mannschaft $mannschaften)
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
     * Add spieltage
     *
     * @param \Liganet\CoreBundle\Entity\Spieltag $spieltage
     * @return LigaSaison
     */
    public function addSpieltage(\Liganet\CoreBundle\Entity\Spieltag $spieltage)
    {
        $this->spieltage[] = $spieltage;
    
        return $this;
    }

    /**
     * Remove spieltage
     *
     * @param \Liganet\CoreBundle\Entity\Spieltag $spieltage
     */
    public function removeSpieltage(\Liganet\CoreBundle\Entity\Spieltag $spieltage)
    {
        $this->spieltage->removeElement($spieltage);
    }

    /**
     * Get spieltage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpieltage()
    {
        return $this->spieltage;
    }



    /**
     * Set actual
     *
     * @param boolean $actual
     * @return LigaSaison
     */
    public function setActual($actual)
    {
        $this->actual = $actual;
    
        return $this;
    }

    /**
     * Get actual
     *
     * @return boolean 
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * Add staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $staffelleiter
     * @return LigaSaison
     */
    public function addStaffelleiter(\Liganet\CoreBundle\Entity\Spieler $staffelleiter)
    {
        $this->staffelleiter[] = $staffelleiter;
    
        return $this;
    }

    /**
     * Remove staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $staffelleiter
     */
    public function removeStaffelleiter(\Liganet\CoreBundle\Entity\Spieler $staffelleiter)
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
}