<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liga
 *
 * @ORM\Table(name="ln_liga")
 * @ORM\Entity(repositoryClass="Liganet\CoreBundle\Entity\LigaRepository")
 */
class Liga
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="farbeTabellenKopf", type="string", length=7)
     */
    private $farbeTabellenKopf;

    /**
     * @var string
     *
     * @ORM\Column(name="farbeTabellenKopfSchrift", type="string", length=7)
     */
    private $farbeTabellenKopfSchrift;

    /**
     * @var string
     *
     * @ORM\Column(name="farbeUeberschriftHintergrund", type="string", length=7)
     */
    private $farbeUeberschriftHintergrund;

    /**
     * @var string
     *
     * @ORM\Column(name="farbeUeberschrift", type="string", length=7)
     */
    private $farbeUeberschrift;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="kuerzel", type="string", length=2)
     */
    private $kuerzel;

    /**
     * @var string
     *
     * @ORM\Column(name="bemerkung", type="text", nullable=true)
     */
    private $bemerkung;

    /**
     * @var string
     *
     * @ORM\Column(name="newsfeed", type="string", length=255, nullable=true)
     */
    private $newsfeed;
    
    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="ligen")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;
    
    /**
     * @ORM\ManyToOne(targetEntity="Modus", inversedBy="ligen")
     * @ORM\JoinColumn(name="modus_id", referencedColumnName="id")
     */
    protected $modus;
    
    /**
     * @ORM\ManyToMany(targetEntity="Spieler", inversedBy="staffelleiter")
     * @ORM\JoinTable(name="ln_spieler_staffelleiter")
     */
    private $staffelleiter;
    
    /**
     * @ORM\OneToMany(targetEntity="LigaSaison", mappedBy="liga")
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
     * Set name
     *
     * @param string $name
     * @return Liga
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set farbeTabellenKopf
     *
     * @param string $farbeTabellenKopf
     * @return Liga
     */
    public function setFarbeTabellenKopf($farbeTabellenKopf)
    {
        $this->farbeTabellenKopf = $farbeTabellenKopf;
    
        return $this;
    }

    /**
     * Get farbeTabellenKopf
     *
     * @return string 
     */
    public function getFarbeTabellenKopf()
    {
        return $this->farbeTabellenKopf;
    }

    /**
     * Set farbeTabellenKopfSchrift
     *
     * @param string $farbeTabellenKopfSchrift
     * @return Liga
     */
    public function setFarbeTabellenKopfSchrift($farbeTabellenKopfSchrift)
    {
        $this->farbeTabellenKopfSchrift = $farbeTabellenKopfSchrift;
    
        return $this;
    }

    /**
     * Get farbeTabellenKopfSchrift
     *
     * @return string 
     */
    public function getFarbeTabellenKopfSchrift()
    {
        return $this->farbeTabellenKopfSchrift;
    }

    /**
     * Set farbeUeberschriftHintergrund
     *
     * @param string $farbeUeberschriftHintergrund
     * @return Liga
     */
    public function setFarbeUeberschriftHintergrund($farbeUeberschriftHintergrund)
    {
        $this->farbeUeberschriftHintergrund = $farbeUeberschriftHintergrund;
    
        return $this;
    }

    /**
     * Get farbeUeberschriftHintergrund
     *
     * @return string 
     */
    public function getFarbeUeberschriftHintergrund()
    {
        return $this->farbeUeberschriftHintergrund;
    }

    /**
     * Set farbeUeberschrift
     *
     * @param string $farbeUeberschrift
     * @return Liga
     */
    public function setFarbeUeberschrift($farbeUeberschrift)
    {
        $this->farbeUeberschrift = $farbeUeberschrift;
    
        return $this;
    }

    /**
     * Get farbeUeberschrift
     *
     * @return string 
     */
    public function getFarbeUeberschrift()
    {
        return $this->farbeUeberschrift;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Liga
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set kuerzel
     *
     * @param string $kuerzel
     * @return Liga
     */
    public function setKuerzel($kuerzel)
    {
        $this->kuerzel = $kuerzel;
    
        return $this;
    }

    /**
     * Get kuerzel
     *
     * @return string 
     */
    public function getKuerzel()
    {
        return $this->kuerzel;
    }

    /**
     * Set bemerkung
     *
     * @param string $bemerkung
     * @return Liga
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
     * Set newsfeed
     *
     * @param string $newsfeed
     * @return Liga
     */
    public function setNewsfeed($newsfeed)
    {
        $this->newsfeed = $newsfeed;
    
        return $this;
    }

    /**
     * Get newsfeed
     *
     * @return string 
     */
    public function getNewsfeed()
    {
        return $this->newsfeed;
    }

    /**
     * Set region
     *
     * @param \Liganet\CoreBundle\Entity\Region $region
     * @return Liga
     */
    public function setRegion(\Liganet\CoreBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Liganet\CoreBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set modus
     *
     * @param \Liganet\CoreBundle\Entity\Modus $modus
     * @return Liga
     */
    public function setModus(\Liganet\CoreBundle\Entity\Modus $modus = null)
    {
        $this->modus = $modus;
    
        return $this;
    }

    /**
     * Get modus
     *
     * @return \Liganet\CoreBundle\Entity\Modus 
     */
    public function getModus()
    {
        return $this->modus;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->staffelleiter = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $staffelleiter
     * @return Liga
     */
    public function addStaffelleiter(\Liganet\CoreBundle\Entity\Spieler $staffelleiter)
    {
        $this->staffelleiter[] = $staffelleiter;
    
        return $this;
    }

    /**
     * Remove staffelleiter
     *
     * @param \Liganet\CoreBundle\Entity\Spieler $staffelleiter
     */
    public function removeStaffelleiter(\Liganet\CoreBundle\Entity\Spieler $staffelleiter)
    {
        $this->staffelleiter->removeElement($staffelleiter);
    }

    /**
     * Get staffelleiter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStaffelleiter()
    {
        return $this->staffelleiter;
    }

    /**
     * Add liga_saison
     *
     * @param \Liganet\CoreBundle\Entity\LigaSaison $ligaSaison
     * @return Liga
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
    
    public function __toString() {
        return $this->name;
    }
}