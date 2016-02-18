<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Tblanrede
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
     * @var string $geschlecht
     *
     * @ORM\Column(name="geschlecht", type="string", length=20, nullable=false)
     */
    private $geschlecht;

    
    public function __toString() {
        return $this->anrede;
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
     * Set anrede
     *
     * @param string $anrede
     *
     * @return Anrede
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
     *
     * @return Anrede
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
     * Set geschlecht
     *
     * @param string $geschlecht
     *
     * @return Anrede
     */
    public function setGeschlecht($geschlecht)
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    /**
     * Get geschlecht
     *
     * @return string
     */
    public function getGeschlecht()
    {
        return $this->geschlecht;
    }
}
