<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpielRunde
 *
 * @ORM\Table(name="ln_spielrunde")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\SpielRundeRepository")
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
     * @param \Liganet\CoreBundle\Entity\Spieltag $spieltag
     * @return SpielRunde
     */
    public function setSpieltag(\Liganet\CoreBundle\Entity\Spieltag $spieltag = null)
    {
        $this->spieltag = $spieltag;
    
        return $this;
    }

    /**
     * Get spieltag
     *
     * @return \Liganet\CoreBundle\Entity\Spieltag 
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
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen
     * @return SpielRunde
     */
    public function addBegegnungen(\Liganet\CoreBundle\Entity\Begegnung $begegnungen)
    {
        $this->begegnungen[] = $begegnungen;
    
        return $this;
    }

    /**
     * Remove begegnungen
     *
     * @param \Liganet\CoreBundle\Entity\Begegnung $begegnungen
     */
    public function removeBegegnungen(\Liganet\CoreBundle\Entity\Begegnung $begegnungen)
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
     * @param \Liganet\CoreBundle\Entity\Tabelle $tabelle
     * @return SpielRunde
     */
    public function addTabelle(\Liganet\CoreBundle\Entity\Tabelle $tabelle)
    {
        $this->tabelle[] = $tabelle;
    
        return $this;
    }

    /**
     * Remove tabelle
     *
     * @param \Liganet\CoreBundle\Entity\Tabelle $tabelle
     */
    public function removeTabelle(\Liganet\CoreBundle\Entity\Tabelle $tabelle)
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