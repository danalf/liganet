<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LigaSaisonRepository
 */
class LigaSaisonRepository extends EntityRepository
{
    public function find($id)
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
}
