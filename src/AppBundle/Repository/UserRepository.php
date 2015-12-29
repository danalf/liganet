<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function find($id)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u,s')
                ->from('User', 'u')
                ->innerJoin('u.Spieler', 's')
                ->where('u.id = ?1')
                ->setParameter(1, $id);

        return $qb->getSingleResult();
    }

}
