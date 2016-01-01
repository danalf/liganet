<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MannschaftSpieler
 *
 * @ORM\Table(name="ln_mannschaft_spieler")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MannschaftSpielerRepository")
 */
class MannschaftSpieler
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
     * @ORM\Column(name="bestaetigt", type="boolean", nullable=true)
     */
    private $bestaetigt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieler", inversedBy="mannschaftSpieler")
     * @ORM\JoinColumn(name="spieler_id", referencedColumnName="id")
     */
    protected $spieler;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mannschaft", inversedBy="mannschaftSpieler")
     * @ORM\JoinColumn(name="mannschaft_id", referencedColumnName="id")
     */
    protected $mannschaft;
    
    /**
     * @ORM\ManyToOne(targetEntity="SpielerStatus", inversedBy="mannschaftSpieler")
     * @ORM\JoinColumn(name="spieler_status_id", referencedColumnName="id")
     */
    protected $status;
    
    


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
     * Set bestaetigt
     *
     * @param boolean $bestaetigt
     * @return MannschaftSpieler
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
     * Set spieler
     *
     * @param \AppBundle\Entity\Spieler $spieler
     * @return MannschaftSpieler
     */
    public function setSpieler(\AppBundle\Entity\Spieler $spieler = null)
    {
        $this->spieler = $spieler;
    
        return $this;
    }

    /**
     * Get spieler
     *
     * @return \AppBundle\Entity\Spieler 
     */
    public function getSpieler()
    {
        return $this->spieler;
    }

    /**
     * Set mannschaft
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaft
     * @return MannschaftSpieler
     */
    public function setMannschaft(\AppBundle\Entity\Mannschaft $mannschaft = null)
    {
        $this->mannschaft = $mannschaft;
    
        return $this;
    }

    /**
     * Get mannschaft
     *
     * @return \AppBundle\Entity\Mannschaft 
     */
    public function getMannschaft()
    {
        return $this->mannschaft;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\SpielerStatus $status
     * @return MannschaftSpieler
     */
    public function setStatus(\AppBundle\Entity\SpielerStatus $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\SpielerStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
