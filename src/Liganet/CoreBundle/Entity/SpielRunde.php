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
}