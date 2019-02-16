<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LigaSaisonRepository
 */
class LigaSaisonRepository extends EntityRepository
{
    public function find($id, $lockMode = NULL, $lockVersion = NULL)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ls,m, st, r')
                ->from('AppBundle:LigaSaison', 'ls')
                ->leftJoin('ls.mannschaften', 'm')
                ->leftJoin('ls.spieltage', 'st')
                ->leftJoin('st.runden', 'r')
                ->where('ls.id = ?1')
                ->setParameter(1, $id);
        
        return $qb->getQuery()->getSingleResult();
    }
    
    public function findBySaisonAndRegion($saison, $region_kuerzel)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ls,l,r')
                ->from('AppBundle:LigaSaison', 'ls')
                ->join('ls.liga', 'l')
                ->join('ls.saison', 's')
                ->join('l.region', 'r')
                ->where('s.saison = ?1')
                ->andWhere('r.name_kurz = ?2')
                ->setParameter(1, $saison)
                ->setParameter(2, $region_kuerzel);
        
        return $qb->getQuery()->getResult();
    }

    /**
     * Find one ligasaison entity by given saison, region and liga
     * 
     * @param int    $saison         Saison like 2019
     * @param string $region_kuerzel Short of region like RNL
     * @param string $liga_kuerzel   short of league like OL for Oberliga
     * 
     * @return AppBundle\Entity\LigaSaison
     */
    public function findOneBySaisonRegionLiga(int $saison, string $region_kuerzel, string $liga_kuerzel)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ls,l,r')
            ->from('AppBundle:LigaSaison', 'ls')
            ->join('ls.liga', 'l')
            ->join('ls.saison', 's')
            ->join('l.region', 'r')
            ->where('s.saison = ?1')
            ->andWhere('r.name_kurz = ?2')
            ->andWhere('l.kuerzel = ?3')
            ->setParameter(1, $saison)
            ->setParameter(2, $region_kuerzel)
            ->setParameter(3, $liga_kuerzel);
        
        return $qb->getQuery()->getSingleResult();
    }
}
