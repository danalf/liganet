<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class VereinRepository extends EntityRepository
{
    /**
     * 
     * @param string $vereinsnummer like 01-123
     */
    public function findOneByVereinsnummer($vereinsnummer){
        $numbers = explode('-', $vereinsnummer);
        if (count($numbers) != 2){
            return null;
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('v')
                ->from('AppBundle:Verein', 'v')
                ->innerJoin('v.region', 'r')
                ->innerJoin('r.verband', 'vb')
                ->where('vb.number = ?1')
                ->andWhere('v.nummer = ?2')
                ->setParameter(1, (int)$numbers[0])
                ->setParameter(2, (int)$numbers[1]);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    /**
     * 
     * @param string $lizenznummer like 01-123-0123
     */
    public function findOneByLizenznummer($lizenznummer){
        $numbers = explode('-', $lizenznummer);
        if (count($numbers) != 3){
            return null;
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('v')
                ->from('AppBundle:Verein', 'v')
                ->where('v.nummer = ?1')
                ->setParameter(1, (int)$numbers[1]);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
}
