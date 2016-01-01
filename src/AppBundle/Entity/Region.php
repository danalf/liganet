<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Document;

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
     * @ORM\OneToMany(targetEntity="Verein", mappedBy="region")
     */
    protected $vereine;

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
     * @ORM\OneToMany(targetEntity="Liga", mappedBy="region")
     */
    protected $ligen;
    
    /**
     * @ORM\ManyToMany(targetEntity="Spieler", inversedBy="regionsleiter")
     * @ORM\JoinTable(name="ln_spieler_regionsleiter")
     */
    private $leiter;

    
    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vereine = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ligen = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leiter = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     *
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
     * Set nameKurz
     *
     * @param string $nameKurz
     *
     * @return Region
     */
    public function setNameKurz($nameKurz)
    {
        $this->name_kurz = $nameKurz;

        return $this;
    }

    /**
     * Get nameKurz
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
     *
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
     *
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
     *
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
     *
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
     *
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
     * Add vereine
     *
     * @param \AppBundle\Entity\Verein $vereine
     *
     * @return Region
     */
    public function addVereine(\AppBundle\Entity\Verein $vereine)
    {
        $this->vereine[] = $vereine;

        return $this;
    }

    /**
     * Remove vereine
     *
     * @param \AppBundle\Entity\Verein $vereine
     */
    public function removeVereine(\AppBundle\Entity\Verein $vereine)
    {
        $this->vereine->removeElement($vereine);
    }

    /**
     * Get vereine
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVereine()
    {
        return $this->vereine;
    }

    /**
     * Set document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return Region
     */
    public function setDocument(\AppBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \AppBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set verband
     *
     * @param \AppBundle\Entity\Verband $verband
     *
     * @return Region
     */
    public function setVerband(\AppBundle\Entity\Verband $verband = null)
    {
        $this->verband = $verband;

        return $this;
    }

    /**
     * Get verband
     *
     * @return \AppBundle\Entity\Verband
     */
    public function getVerband()
    {
        return $this->verband;
    }

    /**
     * Add ligen
     *
     * @param \AppBundle\Entity\Liga $ligen
     *
     * @return Region
     */
    public function addLigen(\AppBundle\Entity\Liga $ligen)
    {
        $this->ligen[] = $ligen;

        return $this;
    }

    /**
     * Remove ligen
     *
     * @param \AppBundle\Entity\Liga $ligen
     */
    public function removeLigen(\AppBundle\Entity\Liga $ligen)
    {
        $this->ligen->removeElement($ligen);
    }

    /**
     * Get ligen
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLigen()
    {
        return $this->ligen;
    }

    /**
     * Add leiter
     *
     * @param \AppBundle\Entity\Spieler $leiter
     *
     * @return Region
     */
    public function addLeiter(\AppBundle\Entity\Spieler $leiter)
    {
        $this->leiter[] = $leiter;

        return $this;
    }

    /**
     * Remove leiter
     *
     * @param \AppBundle\Entity\Spieler $leiter
     */
    public function removeLeiter(\AppBundle\Entity\Spieler $leiter)
    {
        $this->leiter->removeElement($leiter);
    }

    /**
     * Get leiter
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeiter()
    {
        return $this->leiter;
    }
}
