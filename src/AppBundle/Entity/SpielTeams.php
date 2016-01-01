<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpielTeams
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpielTeamsRepository")
 */
class SpielTeams
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
     * @ORM\Column(name="position1", type="boolean")
     */
    private $position1;

    /**
     * @var integer
     *
     * @ORM\Column(name="punkte", type="smallint")
     */
    private $punkte;
    
    


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
     * Set position1
     *
     * @param boolean $position1
     * @return SpielTeams
     */
    public function setPosition1($position1)
    {
        $this->position1 = $position1;
    
        return $this;
    }

    /**
     * Get position1
     *
     * @return boolean 
     */
    public function getPosition1()
    {
        return $this->position1;
    }

    /**
     * Set punkte
     *
     * @param integer $punkte
     * @return SpielTeams
     */
    public function setPunkte($punkte)
    {
        $this->punkte = $punkte;
    
        return $this;
    }

    /**
     * Get punkte
     *
     * @return integer 
     */
    public function getPunkte()
    {
        return $this->punkte;
    }
}
