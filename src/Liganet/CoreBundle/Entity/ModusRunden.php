<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModusRunden
 *
 * @ORM\Table(name="ln_modus_runden")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\ModusRundenRepository")
 */
class ModusRunden
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="beschreibung", type="text")
     */
    private $beschreibung;
    
    /**
     * @ORM\OneToMany(targetEntity="Modus", mappedBy="modusRunden")
     */
    protected $modus;


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
     * @return ModusRunden
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
     * Set beschreibung
     *
     * @param string $beschreibung
     * @return ModusRunden
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    
        return $this;
    }

    /**
     * Get beschreibung
     *
     * @return string 
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modus = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add modus
     *
     * @param \Liganet\CoreBundle\Entity\Modus $modus
     * @return ModusRunden
     */
    public function addModu(\Liganet\CoreBundle\Entity\Modus $modus)
    {
        $this->modus[] = $modus;
    
        return $this;
    }

    /**
     * Remove modus
     *
     * @param \Liganet\CoreBundle\Entity\Modus $modus
     */
    public function removeModu(\Liganet\CoreBundle\Entity\Modus $modus)
    {
        $this->modus->removeElement($modus);
    }

    /**
     * Get modus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModus()
    {
        return $this->modus;
    }
    
    public function __toString() {
        return $this->name;
    }
}