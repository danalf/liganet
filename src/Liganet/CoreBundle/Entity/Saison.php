<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Saison
 *
 * @ORM\Table(name="ln_saison")
 * @ORM\Entity
 */
class Saison
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
     * @ORM\Column(name="saison", type="smallint")
     */
    private $saison;
    
     /**
     * @ORM\OneToMany(targetEntity="LigaSaison", mappedBy="saison")
     */
    protected $liga_saison;


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
     * Set saison
     *
     * @param integer $saison
     * @return Saison
     */
    public function setSaison($saison)
    {
        $this->saison = $saison;
    
        return $this;
    }

    /**
     * Get saison
     *
     * @return integer 
     */
    public function getSaison()
    {
        return $this->saison;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liga = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add liga
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $liga
     * @return Saison
     */
    public function addLiga(\Liganet\CoreBundle\Entity\LigaSaison $liga)
    {
        $this->liga[] = $liga;
    
        return $this;
    }

    /**
     * Remove liga
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $liga
     */
    public function removeLiga(\Liganet\CoreBundle\Entity\LigaSaison $liga)
    {
        $this->liga->removeElement($liga);
    }

    /**
     * Get liga
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiga()
    {
        return $this->liga;
    }

    /**
     * Add liga_saison
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $ligaSaison
     * @return Saison
     */
    public function addLigaSaison(\Liganet\CoreBundle\Entity\LigaSaison $ligaSaison)
    {
        $this->liga_saison[] = $ligaSaison;
    
        return $this;
    }

    /**
     * Remove liga_saison
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $ligaSaison
     */
    public function removeLigaSaison(\Liganet\CoreBundle\Entity\LigaSaison $ligaSaison)
    {
        $this->liga_saison->removeElement($ligaSaison);
    }

    /**
     * Get liga_saison
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLigaSaison()
    {
        return $this->liga_saison;
    }
}