<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\LigaSaison;
use AppBundle\Entity\Spieler;

/**
 * SpieltagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpieltagRepository extends EntityRepository
{
    public function findByLigaSaisonOrdered(LigaSaison $ligasaison)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT s FROM AppBundle:Spieltag s WHERE s.ligasaison='.$ligasaison->getId()."ORDER BY s.nummer ASC")
            ->getResult();
    }
    
    public function findBySpieler(Spieler $spieler) {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('t')
                ->from('AppBundle:Spieltag', 't')
                ->orderBy('t.datum', 'DESC')
                ->join('t.runden', 'r')
                ->join('r.begegnungen', 'b')
                ->join('b.ergebnisse', 'e')
                ->where($qb->expr()->orx(
                                $qb->expr()->eq('e.spieler1_1', '?1'), 
                         $qb->expr()->eq('e.spieler1_2', '?1'),
                        $qb->expr()->eq('e.spieler1_3', '?1'),
                        $qb->expr()->eq('e.spieler2_1', '?1'),
                        $qb->expr()->eq('e.spieler2_2', '?1'),
                        $qb->expr()->eq('e.spieler2_3', '?1'),
                        $qb->expr()->eq('e.ersatz1', '?1'),
                        $qb->expr()->eq('e.ersatz2', '?1')
                ))
               ->groupBy('t.id')
               ->setParameter(1, $spieler->getId())
        ;

        return $qb->getQuery()->getResult();
    }
}
