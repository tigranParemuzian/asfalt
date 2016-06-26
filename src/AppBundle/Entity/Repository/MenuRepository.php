<?php

namespace AppBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 5/29/16
 * Time: 5:26 PM
 */
class MenuRepository extends EntityRepository
{
    public function findData()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT m, a FROM AppBundle:Menu m
                            LEFT JOIN m.article a

                  ')
            ->getResult()
            ;
    }

    public function findMenu()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT m FROM AppBundle:Menu m
                            GROUP BY m.slug
                            ORDER BY m.position

                  ')
            ->getResult()
            ;
    }

}