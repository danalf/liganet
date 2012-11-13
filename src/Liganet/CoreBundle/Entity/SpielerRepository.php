<?php
namespace Liganet\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;


class SpielerRepository extends EntityRepository
{
    public function findAllByVerein(Verein $verein)
    {
        return $verein->getSpieler();
    }
}
