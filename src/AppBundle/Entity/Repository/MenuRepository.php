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
    /**
     * This function use to get articles by menu slug
     * @param $slug
     * @return array
     */
    public function findData($slug)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT m, a FROM AppBundle:Menu m
                            LEFT JOIN m.article a
                            WHERE m.slug = :slug

                  ')
            ->setParameter('slug', $slug)
            ->getOneOrNullResult()
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