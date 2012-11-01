<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Liganet\CoreBundle\Entity\Document;

/**
 * @ORM\Entity
 * @ORM\Table(name="ln_region")
 */
class Region {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $name_kurz;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToOne(targetEntity="Document",cascade={"persist"})
     * @ORM\JoinColumn(name="logo_id", referencedColumnName="id")
     * */
    private $document;
    
     /**
     * @ORM\Column(type="string", length=7)
     */
    protected $farbeTabelleSchrift;
    
    /**
     * @ORM\Column(type="string", length=7)
     */
    protected $farbeTabelleHintergrund;
    
    /**
     * @ORM\Column(type="string", length=7)
     */
    protected $farbeTabelleZeile2Schrift;
    
    /**
     * @ORM\Column(type="string", length=7)
     */
    protected $farbeTabelleZeile2Hintergrund;
    
    /**
     * @ORM\ManyToOne(targetEntity="Verband", inversedBy="regions")
     * @ORM\JoinColumn(name="verband_id", referencedColumnName="id")
     */
    protected $verband;

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
     * @return Region
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
     * Set name_kurz
     *
     * @param string $nameKurz
     * @return Region
     */
    public function setNameKurz($nameKurz)
    {
        $this->name_kurz = $nameKurz;
    
        return $this;
    }

    /**
     * Get name_kurz
     *
     * @return string 
     */
    public function getNameKurz()
    {
        return $this->name_kurz;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Region
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set farbeTabelleSchrift
     *
     * @param string $farbeTabelleSchrift
     * @return Region
     */
    public function setFarbeTabelleSchrift($farbeTabelleSchrift)
    {
        $this->farbeTabelleSchrift = $farbeTabelleSchrift;
    
        return $this;
    }

    /**
     * Get farbeTabelleSchrift
     *
     * @return string 
     */
    public function getFarbeTabelleSchrift()
    {
        return $this->farbeTabelleSchrift;
    }

    /**
     * Set farbeTabelleHintergrund
     *
     * @param string $farbeTabelleHintergrund
     * @return Region
     */
    public function setFarbeTabelleHintergrund($farbeTabelleHintergrund)
    {
        $this->farbeTabelleHintergrund = $farbeTabelleHintergrund;
    
        return $this;
    }

    /**
     * Get farbeTabelleHintergrund
     *
     * @return string 
     */
    public function getFarbeTabelleHintergrund()
    {
        return $this->farbeTabelleHintergrund;
    }

    /**
     * Set farbeTabelleZeile2Schrift
     *
     * @param string $farbeTabelleZeile2Schrift
     * @return Region
     */
    public function setFarbeTabelleZeile2Schrift($farbeTabelleZeile2Schrift)
    {
        $this->farbeTabelleZeile2Schrift = $farbeTabelleZeile2Schrift;
    
        return $this;
    }

    /**
     * Get farbeTabelleZeile2Schrift
     *
     * @return string 
     */
    public function getFarbeTabelleZeile2Schrift()
    {
        return $this->farbeTabelleZeile2Schrift;
    }

    /**
     * Set farbeTabelleZeile2Hintergrund
     *
     * @param string $farbeTabelleZeile2Hintergrund
     * @return Region
     */
    public function setFarbeTabelleZeile2Hintergrund($farbeTabelleZeile2Hintergrund)
    {
        $this->farbeTabelleZeile2Hintergrund = $farbeTabelleZeile2Hintergrund;
    
        return $this;
    }

    /**
     * Get farbeTabelleZeile2Hintergrund
     *
     * @return string 
     */
    public function getFarbeTabelleZeile2Hintergrund()
    {
        return $this->farbeTabelleZeile2Hintergrund;
    }

    /**
     * Set document
     *
     * @param Liganet\CoreBundle\Entity\Document $document
     * @return Region
     */
    public function setDocument(\Liganet\CoreBundle\Entity\Document $document = null)
    {
        $this->document = $document;
    
        return $this;
    }

    /**
     * Get document
     *
     * @return Liganet\CoreBundle\Entity\Document 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set verband
     *
     * @param Liganet\CoreBundle\Entity\Verband $verband
     * @return Region
     */
    public function setVerband(\Liganet\CoreBundle\Entity\Verband $verband = null)
    {
        $this->verband = $verband;
    
        return $this;
    }

    /**
     * Get verband
     *
     * @return Liganet\CoreBundle\Entity\Verband 
     */
    public function getVerband()
    {
        return $this->verband;
    }
}