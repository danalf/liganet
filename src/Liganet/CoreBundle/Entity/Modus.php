<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modus
 *
 * @ORM\Table(name="ln_modus")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\ModusRepository")
 */
class Modus
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
     * @var integer
     *
     * @ORM\Column(name="anzahlRunden", type="smallint", nullable=true)
     */
    private $anzahlRunden;
    
    /**
     * @ORM\ManyToOne(targetEntity="ModusRunden", inversedBy="modus")
     * @ORM\JoinColumn(name="modusrunden_id", referencedColumnName="id")
     */
    protected $modusRunden;


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
     * @return Modus
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
     * Set anzahlRunden
     *
     * @param integer $anzahlRunden
     * @return Modus
     */
    public function setAnzahlRunden($anzahlRunden)
    {
        $this->anzahlRunden = $anzahlRunden;
    
        return $this;
    }

    /**
     * Get anzahlRunden
     *
     * @return integer 
     */
    public function getAnzahlRunden()
    {
        return $this->anzahlRunden;
    }

    /**
     * Set modusRunden
     *
     * @param \Liganet\CoreBundle\Entity\ModusRunden $modusRunden
     * @return Modus
     */
    public function setModusRunden(\Liganet\CoreBundle\Entity\ModusRunden $modusRunden = null)
    {
        $this->modusRunden = $modusRunden;
    
        return $this;
    }

    /**
     * Get modusRunden
     *
     * @return \Liganet\CoreBundle\Entity\ModusRunden 
     */
    public function getModusRunden()
    {
        return $this->modusRunden;
    }
}