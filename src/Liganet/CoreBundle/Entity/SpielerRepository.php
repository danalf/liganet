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
}
