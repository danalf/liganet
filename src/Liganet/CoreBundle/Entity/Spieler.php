<?php

namespace Liganet\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ln_spieler")
 */
class Spieler {

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
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $vorname;
    
    /**
     * @ORM\ManyToOne(targetEntity="Verein", inversedBy="spieler")
     * @ORM\JoinColumn(name="verein_id", referencedColumnName="id")
     */
    protected $verein;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set vorname
     *
     * @param string $vorname
     * @return Spieler
     */
    public function setVorname($vorname) {
        $this->vorname = $vorname;

        return $this;
    }

    /**
     * Get vorname
     *
     * @return string 
     */
    public function getVorname() {
        return $this->vorname;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Spieler
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
     * Set verein
     *
     * @param Liganet\CoreBundle\Entity\Verein $verein
     * @return Spieler
     */
    public function setVerein(\Liganet\CoreBundle\Entity\Verein $verein = null)
    {
        $this->verein = $verein;
    
        return $this;
    }

    /**
     * Get verein
     *
     * @return Liganet\CoreBundle\Entity\Verein 
     */
    public function getVerein()
    {
        return $this->verein;
    }
    
    public function getArray(){
             return array(
            'id'        => $this->getId(),
            'name' => $this->getName(),
            'vorname'   => $this->getVorname(),
            'verein'  => $this->getVerein()->getName()
             );


        }
}