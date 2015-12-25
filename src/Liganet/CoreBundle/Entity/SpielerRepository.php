<?php
namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;


class SpielerRepository extends EntityRepository
{
    public function findAllByVerein(Verein $verein)
    {
        return $verein->getSpieler();
    }
    
    public function findAllByMannschaft($mannschaft_id)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('s')
            ->from('Spieler', 's')
            ->innerJoin('s.MannschaftSpieler', 'm', 'WITH', 'm.Mannschaft = '.$mannschaft_id)
            ->orderBy('s.Nachname', 'ASC');
        
        return $qb->getResult();
    }
    
    public function findAllByVereinIdOrdered($verein_id)
    {
        //$qb = $this->getEntityManager()->createQueryBuilder();
        $qb = $this->_em->createQuery("SELECT s FROM LiganetCoreBundle:Spieler s WHERE s.verein = $verein_id ORDER BY s.nummerlizenz ASC");
//        $qb->select('s')
//            ->from('Spieler', 's')
//            ->where('u.verein.id = ?1')
//            ->orderBy('s.nummerlizenz ASC')
//            ->setParameter(1, $verein_id);
        return $qb->getResult();
    }
    
    public function findAllByRegionIdOrdered($region_id)
    {
        //$qb = $this->getEntityManager()->createQueryBuilder();
        $qb = $this->_em->createQuery("SELECT s FROM LiganetCoreBundle:Spieler s JOIN s.verein v WHERE v.region = $region_id ORDER BY s.nachname ASC, s.vorname ASC");
//        $qb->select('s')
//            ->from('Spieler', 's')
//            ->where('u.verein.id = ?1')
//            ->orderBy('s.nummerlizenz ASC')
//            ->setParameter(1, $verein_id);
        return $qb->getResult();
    }
}
