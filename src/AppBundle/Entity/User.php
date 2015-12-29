<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Liganet\CoreBundle\Entity\Spieler;


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
     * @ORM\OneToOne(targetEntity="Liganet\CoreBundle\Entity\Spieler", inversedBy="user")
     * @ORM\JoinColumn(name="spieler", referencedColumnName="id")
     */
    private $spieler;
    
    /**
     * @ORM\OneToMany(targetEntity="Liganet\CoreBundle\Entity\DataLog", mappedBy="user")
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
     * @param Liganet\CoreBundle\Entity\Spieler $spieler
     * @return User
     */
    public function setSpieler(\Liganet\CoreBundle\Entity\Spieler $spieler = null)
    {
        $this->spieler = $spieler->getId();
    
        return $this;
    }

    /**
     * Get spieler
     *
     * @return Liganet\CoreBundle\Entity\Spieler 
     */
    public function getSpieler()
    {
        return $this->spieler;
    }
    


    /**
     * Add change
     *
     * @param \Liganet\CoreBundle\Entity\DataLog $change
     *
     * @return User
     */
    public function addChange(\Liganet\CoreBundle\Entity\DataLog $change)
    {
        $this->changes[] = $change;

        return $this;
    }

    /**
     * Remove change
     *
     * @param \Liganet\CoreBundle\Entity\DataLog $change
     */
    public function removeChange(\Liganet\CoreBundle\Entity\DataLog $change)
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
