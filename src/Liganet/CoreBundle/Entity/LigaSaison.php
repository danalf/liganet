<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigaSaison
 *
 * @ORM\Table(name="ln_liga_saison")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\LigaSaisonRepository")
 */
class LigaSaison
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
     * @var boolean
     *
     * @ORM\Column(name="gesperrt", type="boolean")
     */
    private $gesperrt;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text")
     */
    private $bemerkung;
    
    /**
     * @ORM\ManyToOne(targetEntity="Saison", inversedBy="liga_saison")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    protected $saison;


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
     * Set gesperrt
     *
     * @param boolean $gesperrt
     * @return LigaSaison
     */
    public function setGesperrt($gesperrt)
    {
        $this->gesperrt = $gesperrt;
    
        return $this;
    }

    /**
     * Get gesperrt
     *
     * @return boolean 
     */
    public function getGesperrt()
    {
        return $this->gesperrt;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return LigaSaison
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
     * Set saison
     *
     * @param \Liganet\CoreBundle\Entity\Saison $saison
     * @return LigaSaison
     */
    public function setSaison(\Liganet\CoreBundle\Entity\Saison $saison = null)
    {
        $this->saison = $saison;
    
        return $this;
    }

    /**
     * Get saison
     *
     * @return \Liganet\CoreBundle\Entity\Saison 
     */
    public function getSaison()
    {
        return $this->saison;
    }
}