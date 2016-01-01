<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tabelle
 *
 * @ORM\Table("ln_tabelle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TabelleRepository")
 */
class Tabelle
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
     * @ORM\Column(name="rang", type="smallint")
     */
    private $rang=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="kugeln1", type="smallint")
     */
    private $kugeln1=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="kugeln2", type="smallint")
     */
    private $kugeln2=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="differenz", type="smallint")
     */
    private $differenz=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="spiele1", type="smallint")
     */
    private $spiele1=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="spiele2", type="smallint")
     */
    private $spiele2=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="punkte1", type="smallint")
     */
    private $punkte1=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="punkte2", type="smallint")
     */
    private $punkte2=0;
    
    /**
     * @ORM\ManyToOne(targetEntity="SpielRunde", inversedBy="tabelle")
     * @ORM\JoinColumn(name="spielrunde_id", referencedColumnName="id")
     */
    protected $spielrunde;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mannschaft", inversedBy="tabellenzeilen")
     * @ORM\JoinColumn(name="mannschaft_id", referencedColumnName="id")
     */
    protected $mannschaft;


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
     * Set rang
     *
     * @param integer $rang
     * @return Tabelle
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    
        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set kugeln1
     *
     * @param integer $kugeln1
     * @return Tabelle
     */
    public function setKugeln1($kugeln1)
    {
        $this->kugeln1 = $kugeln1;
    
        return $this;
    }

    /**
     * Get kugeln1
     *
     * @return integer 
     */
    public function getKugeln1()
    {
        return $this->kugeln1;
    }

    /**
     * Set kugeln2
     *
     * @param integer $kugeln2
     * @return Tabelle
     */
    public function setKugeln2($kugeln2)
    {
        $this->kugeln2 = $kugeln2;
    
        return $this;
    }

    /**
     * Get kugeln2
     *
     * @return integer 
     */
    public function getKugeln2()
    {
        return $this->kugeln2;
    }

    /**
     * Set differenz
     *
     * @param integer $differenz
     * @return Tabelle
     */
    public function setDifferenz($differenz)
    {
        $this->differenz = $differenz;
    
        return $this;
    }

    /**
     * Get differenz
     *
     * @return integer 
     */
    public function getDifferenz()
    {
        return $this->differenz;
    }

    /**
     * Set spiele1
     *
     * @param integer $spiele1
     * @return Tabelle
     */
    public function setSpiele1($spiele1)
    {
        $this->spiele1 = $spiele1;
    
        return $this;
    }

    /**
     * Get spiele1
     *
     * @return integer 
     */
    public function getSpiele1()
    {
        return $this->spiele1;
    }

    /**
     * Set spiele2
     *
     * @param integer $spiele2
     * @return Tabelle
     */
    public function setSpiele2($spiele2)
    {
        $this->spiele2 = $spiele2;
    
        return $this;
    }

    /**
     * Get spiele2
     *
     * @return integer 
     */
    public function getSpiele2()
    {
        return $this->spiele2;
    }

    /**
     * Set punkte1
     *
     * @param integer $punkte1
     * @return Tabelle
     */
    public function setPunkte1($punkte1)
    {
        $this->punkte1 = $punkte1;
    
        return $this;
    }

    /**
     * Get punkte1
     *
     * @return integer 
     */
    public function getPunkte1()
    {
        return $this->punkte1;
    }

    /**
     * Set punkte2
     *
     * @param integer $punkte2
     * @return Tabelle
     */
    public function setPunkte2($punkte2)
    {
        $this->punkte2 = $punkte2;
    
        return $this;
    }

    /**
     * Get punkte2
     *
     * @return integer 
     */
    public function getPunkte2()
    {
        return $this->punkte2;
    }

    /**
     * Set spielrunde
     *
     * @param \AppBundle\Entity\SpielRunde $spielrunde
     * @return Tabelle
     */
    public function setSpielrunde(\AppBundle\Entity\SpielRunde $spielrunde = null)
    {
        $this->spielrunde = $spielrunde;
    
        return $this;
    }

    /**
     * Get spielrunde
     *
     * @return \AppBundle\Entity\SpielRunde 
     */
    public function getSpielrunde()
    {
        return $this->spielrunde;
    }

    /**
     * Set mannschaft
     *
     * @param \AppBundle\Entity\Mannschaft $mannschaft
     * @return Tabelle
     */
    public function setMannschaft(\AppBundle\Entity\Mannschaft $mannschaft = null)
    {
        $this->mannschaft = $mannschaft;
    
        return $this;
    }

    /**
     * Get mannschaft
     *
     * @return \AppBundle\Entity\Mannschaft 
     */
    public function getMannschaft()
    {
        return $this->mannschaft;
    }
    
    static function compare(Tabelle $a, Tabelle $b) {
        $al = $a->compareValue();
        $bl = $b->compareValue();
        if ($al == $bl) {
            //hier muss noch der direkte Vergleich rein
            return 0;
        }
        return ($al < $bl) ? +1 : -1;
    }

    private function compareValue() {
        return $this->differenz - (1000 * $this->spiele2) + (100000 * $this->spiele1) - (10000000 * $this->punkte2) + (1000000000 * $this->punkte1);
    }
    
    public function reset(){
        unset($this->mannschaft1);
        unset($this->mannschaft2);
        $this->rang=0;
        $this->kugeln1=0;
        $this->kugeln2=0;
        $this->spiele1=0;
        $this->spiele2=0;
        $this->punkte1=0;
        $this->punkte2=0;
    }
    
    
}
