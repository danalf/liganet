<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Spieltag;
use AppBundle\Entity\LigaSaison;

/**
 * SpielRundeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpielRundeRepository extends EntityRepository
{
    public function find($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s,t,b')
                ->from('AppBundle:SpielRunde', 's')
                ->join('s.tabelle', 't')
                ->join('s.begegnungen', 'b')
                ->where('s.id = ?1')
                ->orderBy('t.rang')
                ->setParameter(1, $id);
        
        return $qb->getQuery()->getSingleResult();
    }
    
    public function findBySpieltagOrdered(Spieltag $spieltag)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT r FROM AppBundle:SpielRunde r WHERE r.spieltag='.$spieltag->getId()." ORDER BY r.nummer ASC ")
            ->getResult();
    }
    
    public function findByLigaSaisonOrdered(LigaSaison $ligasaison)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT r FROM AppBundle:SpielRunde r JOIN r.spieltag s WHERE s.ligasaison='.$ligasaison->getId()." ORDER BY r.nummer ASC ")
            ->getResult();
    }
}
