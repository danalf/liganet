<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpielRunde
 *
 * @ORM\Table(name="ln_spielrunde")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpielRundeRepository")
 */
class SpielRunde
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
     * @ORM\Column(name="nummer", type="smallint")
     */
    private $nummer;
    
    /**
     * @ORM\ManyToOne(targetEntity="Spieltag", inversedBy="runden")
     * @ORM\JoinColumn(name="spieltag_id", referencedColumnName="id")
     */
    protected $spieltag;
    
    /**
     * @ORM\OneToMany(targetEntity="Begegnung", mappedBy="spielRunde")
     */
    protected $begegnungen;
    
    /**
     * @ORM\OneToMany(targetEntity="Tabelle", mappedBy="spielrunde")
     */
    protected $tabelle;


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
     * Set nummer
     *
     * @param integer $nummer
     * @return SpielRunde
     */
    public function setNummer($nummer)
    {
        $this->nummer = $nummer;
    
        return $this;
    }

    /**
     * Get nummer
     *
     * @return integer 
     */
    public function getNummer()
    {
        return $this->nummer;
    }

    /**
     * Set spieltag
     *
     * @param \AppBundle\Entity\Spieltag $spieltag
     * @return SpielRunde
     */
    public function setSpieltag(\AppBundle\Entity\Spieltag $spieltag = null)
    {
        $this->spieltag = $spieltag;
    
        return $this;
    }

    /**
     * Get spieltag
     *
     * @return \AppBundle\Entity\Spieltag 
     */
    public function getSpieltag()
    {
        return $this->spieltag;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->begegnungen = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add begegnungen
     *
     * @param \AppBundle\Entity\Begegnung $begegnungen
     * @return SpielRunde
     */
    public function addBegegnungen(\AppBundle\Entity\Begegnung $begegnungen)
    {
        $this->begegnungen[] = $begegnungen;
    
        return $this;
    }

    /**
     * Remove begegnungen
     *
     * @param \AppBundle\Entity\Begegnung $begegnungen
     */
    public function removeBegegnungen(\AppBundle\Entity\Begegnung $begegnungen)
    {
        $this->begegnungen->removeElement($begegnungen);
    }

    /**
     * Get begegnungen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBegegnungen()
    {
        return $this->begegnungen;
    }

    /**
     * Add tabelle
     *
     * @param \AppBundle\Entity\Tabelle $tabelle
     * @return SpielRunde
     */
    public function addTabelle(\AppBundle\Entity\Tabelle $tabelle)
    {
        $this->tabelle[] = $tabelle;
    
        return $this;
    }

    /**
     * Remove tabelle
     *
     * @param \AppBundle\Entity\Tabelle $tabelle
     */
    public function removeTabelle(\AppBundle\Entity\Tabelle $tabelle)
    {
        $this->tabelle->removeElement($tabelle);
    }

    /**
     * Get tabelle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTabelle()
    {
        return $this->tabelle;
    }
    
    public function __toString() {
        return $this->getSpieltag()->getLigasaison()." Runde ".$this->nummer;
    }
}
