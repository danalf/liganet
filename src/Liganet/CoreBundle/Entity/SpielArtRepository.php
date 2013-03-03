<?php

namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SpielArtRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpielArtRepository extends EntityRepository
{
    public function findByModusOrdered(Modus $modus)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT sa FROM LiganetCoreBundle:SpielArt sa WHERE sa.modus='.$modus->getId()."ORDER BY sa.nummer ASC")
            ->getResult();
    }
}
