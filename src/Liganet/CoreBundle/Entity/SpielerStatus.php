<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpielerStatus
 *
 * @ORM\Table(name="ln_spieler_status")
 * @ORM\Entity
 */
class SpielerStatus
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
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="kurz", type="string", length=2)
     */
    private $kurz;
    
    /**
     * @ORM\OneToMany(targetEntity="MannschaftSpieler", mappedBy="status")
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
     * Set name
     *
     * @param string $name
     * @return SpielerStatus
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
     * Set kurz
     *
     * @param string $kurz
     * @return SpielerStatus
     */
    public function setKurz($kurz)
    {
        $this->kurz = $kurz;
    
        return $this;
    }

    /**
     * Get kurz
     *
     * @return string 
     */
    public function getKurz()
    {
        return $this->kurz;
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
     * @return SpielerStatus
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
    
    public function __toString() {
        return $this->name;
    }
}