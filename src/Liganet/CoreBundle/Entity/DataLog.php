<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * Log
 *
 * @ORM\Table("ln_log")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\DataLogRepository")
 */
class DataLog {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_type", type="string", length=255)
     */
    private $entity_type;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entity_id;

    /**
     * @var array
     *
     * @ORM\Column(name="changes", type="array")
     */
    private $changes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Liganet\UserBundle\Entity\User", inversedBy="changes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    public function __construct() {
        $this->date = new \DateTime;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set entity_type
     *
     * @param string $entityType
     * @return Log
     */
    public function setEntityType($entityType) {
        $this->entity_type = $entityType;

        return $this;
    }

    /**
     * Get entity_type
     *
     * @return string 
     */
    public function getEntityType() {
        return $this->entity_type;
    }

    /**
     * Set entity_id
     *
     * @param integer $entityId
     * @return Log
     */
    public function setEntityId($entityId) {
        $this->entity_id = $entityId;

        return $this;
    }

    /**
     * Get entity_id
     *
     * @return integer 
     */
    public function getEntityId() {
        return $this->entity_id;
    }

    /**
     * Set changes
     *
     * @param array $changes
     * @return Log
     */
    public function setChanges($changes) {
        $this->changes = $changes;

        return $this;
    }

    /**
     * Get changes
     *
     * @return array 
     */
    public function getChanges() {
        return $this->changes;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $date
     * @return Log
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \Liganet\UserBundle\Entity\User $user
     * @return Log
     */
    public function setUser(\Liganet\UserBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Liganet\UserBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    public function toArray() {
        $array = array();
        $array["user"] = $this->getUser();
        $array["date"] = $this->getDate();
        $array["entity_type"] = $this->getEntityType();
        $array["entity_id"] = $this->getEntityId();
        $array["changes"] = $this->object2array($this->getChanges());
        return $array;
    }

    function object2array($obj) {
        $arr = array();
        foreach ($this->getChanges() as $key => $value) {
            $item = array();
            $item["type"] = $key;

            if (is_object($value[0])) {
                $value[0]=0;
                $value[1]=0;
            } 
            $item["old"] = $value[0];
            $item["new"] = $value[1];
            array_push($arr, $item);
        }
        return $arr;
    }

}