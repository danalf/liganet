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
}
