<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modus
 *
 * @ORM\Table(name="ln_modus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModusRepository")
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
     * @ORM\OneToMany(targetEntity="Liga", mappedBy="modus")
     */
    protected $ligen;
    
    /**
     * @ORM\OneToMany(targetEntity="SpielArt", mappedBy="modus")
     * @ORM\OrderBy({"nummer" = "ASC"})
     */
    protected $spielArt;


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
     * @param \AppBundle\Entity\ModusRunden $modusRunden
     * @return Modus
     */
    public function setModusRunden(\AppBundle\Entity\ModusRunden $modusRunden = null)
    {
        $this->modusRunden = $modusRunden;
    
        return $this;
    }

    /**
     * Get modusRunden
     *
     * @return \AppBundle\Entity\ModusRunden 
     */
    public function getModusRunden()
    {
        return $this->modusRunden;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ligen = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ligen
     *
     * @param \AppBundle\Entity\Liga $ligen
     * @return Modus
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
    
    public function __toString() {
        return $this->name;
    }

    /**
     * Add spielArt
     *
     * @param \AppBundle\Entity\SpielArt $spielArt
     * @return Modus
     */
    public function addSpielArt(\AppBundle\Entity\SpielArt $spielArt)
    {
        $this->spielArt[] = $spielArt;
    
        return $this;
    }

    /**
     * Remove spielArt
     *
     * @param \AppBundle\Entity\SpielArt $spielArt
     */
    public function removeSpielArt(\AppBundle\Entity\SpielArt $spielArt)
    {
        $this->spielArt->removeElement($spielArt);
    }

    /**
     * Get spielArt
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpielArt()
    {
        return $this->spielArt;
    }
    
    /**
     * Gibt die maximale Anzahl von Partien gleichzeitig bei einer Begegnung zurück
     * @return int
     */
    public function getMaxAnzahlSpieleGleichzeitig(){
        $anzahl=array();
        foreach ($this->getSpielArt() as $spielart) {
            if(isset($anzahl[$spielart->getReihenfolge()])){
                $anzahl[$spielart->getReihenfolge()] +=1;
            } else {
                $anzahl[$spielart->getReihenfolge()] =1;
            }
            
        }
        sort($anzahl);
        return $anzahl[count($anzahl)-1];
    }
    
    /**
     * Gibt die Anzahl der Partien hintereinander bei einer Begegnung zurück
     * @return int
     */
    public function getAnzahlSpieleHintereinander(){
        $anzahl=array();
        foreach ($this->getSpielArt() as $spielart) {
            if(isset($anzahl[$spielart->getReihenfolge()])){
                $anzahl[$spielart->getReihenfolge()] +=1;
            } else {
                $anzahl[$spielart->getReihenfolge()] =1;
            }
            
        }
        return count($anzahl);
    }
}
