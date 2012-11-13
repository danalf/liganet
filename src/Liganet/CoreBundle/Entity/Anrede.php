<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liganet\CoreBundle\Entity\Tblanrede
 *
 * @ORM\Table(name="ln_anrede")
 * @ORM\Entity
 */
class Anrede
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string $anrede
     *
     * @ORM\Column(name="anrede", type="string", length=5, nullable=false)
     */
    private $anrede;

    /**
     * @var string $brief
     *
     * @ORM\Column(name="brief", type="string", length=20, nullable=false)
     */
    private $brief;



    /**
     * Get idtblanrede
     *
     * @return boolean 
     */
    public function getIdtblanrede()
    {
        return $this->idtblanrede;
    }

    /**
     * Set anrede
     *
     * @param string $anrede
     * @return Tblanrede
     */
    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
    
        return $this;
    }

    /**
     * Get anrede
     *
     * @return string 
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * Set brief
     *
     * @param string $brief
     * @return Tblanrede
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;
    
        return $this;
    }

    /**
     * Get brief
     *
     * @return string 
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString() {
        return $this->anrede;
    }
}