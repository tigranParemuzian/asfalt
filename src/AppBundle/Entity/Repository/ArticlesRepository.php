<?php
/**
 * Created by PhpStorm.
 * User: developer-01
 * Date: 6/27/16
 * Time: 6:07 PM
 */

namespace AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class ArticlesRepository extends EntityRepository
{
    public function findByMenuSlug($slug)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT a, m
                            FROM AppBundle:Articles a
                            LIKE JOIN a.menu m
                            WHERE m.slug = :slug
                            ORDER BY a.position
                          ')
            ->setParameter('slug', $slug)
            ->getResult()
            ;
    }

}