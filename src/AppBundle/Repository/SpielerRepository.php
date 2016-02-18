<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class SpielerRepository extends EntityRepository
{
    public function zzzfind($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s,v')
                ->from('AppBundle:Spieler', 's')
                ->innerJoin('s.Verein', 'v')
                ->where('s.id = ?1')
                ->setParameter(1, $id);
        
        return $qb->getQuery()->getSingleResult();
    }
    
    public function findAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s,v')
                ->from('AppBundle:Spieler', 's')
                ->innerJoin('s.verein', 'v');
        
        return $qb->getQuery()->getResult();
    }
    
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
        $qb = $this->_em->createQuery("SELECT s FROM AppBundle:Spieler s WHERE s.verein = $verein_id ORDER BY s.nummerlizenz ASC");
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
        $qb = $this->_em->createQuery("SELECT s FROM AppBundle:Spieler s JOIN s.verein v WHERE v.region = $region_id ORDER BY s.nachname ASC, s.vorname ASC");
//        $qb->select('s')
//            ->from('Spieler', 's')
//            ->where('u.verein.id = ?1')
//            ->orderBy('s.nummerlizenz ASC')
//            ->setParameter(1, $verein_id);
        return $qb->getResult();
    }
    
    /**
     * 
     * @param string $lizenznummer
     * @param string $vorname
     * @param string $nachname
     * @return type
     */
    public function findOneByLizenznummerAndName($lizenznummer, $vorname, $nachname){
        $numbers = explode('-', $lizenznummer);
        if (count($numbers) != 3){
            return null;
        }
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
                ->from('AppBundle:Spieler', 's')
                ->innerJoin('s.verein', 'v')
                ->innerJoin('v.region', 'r')
                ->innerJoin('r.verband', 'vb')
                ->where('vb.number = ?1')
                ->andWhere('v.nummer = ?2')
                ->andWhere('s.nummerlizenz = ?3')
                ->andWhere('s.vorname = ?4')
                ->andWhere('s.nachname = ?5')
                ->setParameter(1, (int)$numbers[0])
                ->setParameter(2, (int)$numbers[1])
                ->setParameter(3, (int)$numbers[2])
                ->setParameter(4, $vorname)
                ->setParameter(5, $nachname);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
}
