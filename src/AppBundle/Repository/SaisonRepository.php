<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SaisonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaisonRepository extends EntityRepository
{
    public function findLast()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('max(s.saison) as year')
                ->from('AppBundle:Saison', 's');
        
        return $qb->getQuery()->getSingleScalarResult();
    }
}
