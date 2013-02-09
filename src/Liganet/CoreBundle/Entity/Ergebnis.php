<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ergebnis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\ErgebnisRepository")
 */
class Ergebnis
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
     * @ORM\Column(name="platz", type="smallint")
     */
    private $platz;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text")
     */
    private $bemerkung;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unterschrift_ligaleiter", type="boolean")
     */
    private $unterschrift_ligaleiter;


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
     * Set platz
     *
     * @param integer $platz
     * @return Ergebnis
     */
    public function setPlatz($platz)
    {
        $this->platz = $platz;
    
        return $this;
    }

    /**
     * Get platz
     *
     * @return integer 
     */
    public function getPlatz()
    {
        return $this->platz;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return Ergebnis
     */
    public function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
    
        return $this;
    }

    /**
     * Get bemerkung
     *
     * @return string 
     */
    public function getBemerkung()
    {
        return $this->bemerkung;
    }

    /**
     * Set unterschrift_ligaleiter
     *
     * @param boolean $unterschriftLigaleiter
     * @return Ergebnis
     */
    public function setUnterschriftLigaleiter($unterschriftLigaleiter)
    {
        $this->unterschrift_ligaleiter = $unterschriftLigaleiter;
    
        return $this;
    }

    /**
     * Get unterschrift_ligaleiter
     *
     * @return boolean 
     */
    public function getUnterschriftLigaleiter()
    {
        return $this->unterschrift_ligaleiter;
    }
}
