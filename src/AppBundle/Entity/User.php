<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Liganet\CoreBundle\Entity\Spieler;


/**
 * @ORM\Entity
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
    

}
