<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="liganet_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Spieler", inversedBy="user")
     * @ORM\JoinColumn(name="spieler", referencedColumnName="id")
     */
    private $spieler;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DataLog", mappedBy="user")
     */
    private $changes;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }




    /**
     * Set spieler
     *
     * @param AppBundle\Entity\Spieler $spieler
     * @return User
     */
    public function setSpieler(\AppBundle\Entity\Spieler $spieler = null)
    {
        $this->spieler = $spieler;
    
        return $this;
    }

    /**
     * Get spieler
     *
     * @return AppBundle\Entity\Spieler 
     */
    public function getSpieler()
    {
        return $this->spieler;
    }
    


    /**
     * Add change
     *
     * @param \AppBundle\Entity\DataLog $change
     *
     * @return User
     */
    public function addChange(\AppBundle\Entity\DataLog $change)
    {
        $this->changes[] = $change;

        return $this;
    }

    /**
     * Remove change
     *
     * @param \AppBundle\Entity\DataLog $change
     */
    public function removeChange(\AppBundle\Entity\DataLog $change)
    {
        $this->changes->removeElement($change);
    }

    /**
     * Get changes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChanges()
    {
        return $this->changes;
    }
}
