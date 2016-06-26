<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function findByOrder()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT m.name, m.slug FROM AppBundle:Menu m
                          ORDER BY m.position ASC ')
            ->getResult()
            ;
    }

}