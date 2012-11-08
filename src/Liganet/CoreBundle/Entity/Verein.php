<?php

namespace Liganet\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ln_verein")
 */
class Verein
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
        /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="verein")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;
    
    /**
     * @ORM\OneToMany(targetEntity="Spieler", mappedBy="verein")
     */
    protected $spieler;

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
     * @return Verein
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
     * Constructor
     */
    public function __construct()
    {
        $this->spieler = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add spieler
     *
     * @param Liganet\CoreBundle\Entity\Spieler $spieler
     * @return Verein
     */
    public function addSpieler(\Liganet\CoreBundle\Entity\Spieler $spieler)
    {
        $this->spieler[] = $spieler;
    
        return $this;
    }

    /**
     * Remove spieler
     *
     * @param Liganet\CoreBundle\Entity\Spieler $spieler
     */
    public function removeSpieler(\Liganet\CoreBundle\Entity\Spieler $spieler)
    {
        $this->spieler->removeElement($spieler);
    }

    /**
     * Get spieler
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSpieler()
    {
        return $this->spieler;
    }

    /**
     * Set region
     *
     * @param Liganet\CoreBundle\Entity\Region $region
     * @return Verein
     */
    public function setRegion(\Liganet\CoreBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return Liganet\CoreBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
}