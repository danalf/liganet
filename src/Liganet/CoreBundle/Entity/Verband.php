<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Liganet\CoreBundle\Entity\Document;

/**
 * @ORM\Entity
 * @ORM\Table(name="verband")
 */
class Verband {
    


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
     * @ORM\Column(type="integer")
     */
    protected $number;

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
     * @ORM\OneToMany(targetEntity="Region", mappedBy="verband")
     */
    protected $regions;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Verband
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Verband
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Verband
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Verband
     */
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Set document
     *
     * @param Liganet\CoreBundle\Entity\Document $document
     * @return Verband
     */
    public function setDocument(\Liganet\CoreBundle\Entity\Document $document = null) {
        if ($document == null) {
            $document = new Document();
        }
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return Liganet\CoreBundle\Entity\Document 
     */
    public function getDocument() {
        return $this->document;
    }


    /**
     * Set name_kurz
     *
     * @param string $nameKurz
     * @return Verband
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
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add regions
     *
     * @param Liganet\CoreBundle\Entity\Region $regions
     * @return Verband
     */
    public function addRegion(\Liganet\CoreBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;
    
        return $this;
    }

    /**
     * Remove regions
     *
     * @param Liganet\CoreBundle\Entity\Region $regions
     */
    public function removeRegion(\Liganet\CoreBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }
}