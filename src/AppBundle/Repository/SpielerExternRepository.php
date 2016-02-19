<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class SpielerExternRepository extends EntityRepository
{

    public function findPartById($fromId, $toId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
                ->from('AppBundle:SpielerExtern', 's')
                ->where($qb->expr()->between('s.id', '?1', '?2'))
                ->setParameter(1, $fromId)
                ->setParameter(2, $toId);
        return $qb->getQuery()->getResult();
    }
    
}
