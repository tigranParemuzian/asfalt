<?php
/**
 * Created by PhpStorm.
 * User: armen
 * Date: 10/21/15
 * Time: 5:26 PM
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;

use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapListener implements SitemapListenerInterface
{

    private $event;

    private $router;

    private $em;

    public function __construct(RouterInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $this->event = $event;

        $section = $this->event->getSection();

        if (is_null($section) || $section == 'default') {

            //get absolute homepage url
            /*$url = $this->router->generate('homepage', array(), true);

            //add homepage url to the urlset named default
            $this->createSitemapEntry($url, new \DateTime(), UrlConcrete::CHANGEFREQ_YEARLY, 1);*/

            $datas =  $this->em->getRepository('AppBundle:AsphaltingTypes')->findAllForSitemap();

            $equipment =  $this->em->getRepository('AppBundle:EquipmentTypes')->findAllForParent();


            foreach ($datas as $blog) {

                $url = $this->router->generate('asphalt_type', array('slug' => $blog->getSlug()), true);

                $blogUpdatedDate = $blog->getUpdated()->format("Y-m-d H:i:s");
                $this->createSitemapEntry($url, new \DateTime($blogUpdatedDate), UrlConcrete::CHANGEFREQ_YEARLY, 0.8);

                if($blog->getIsSingle() == false) {

                    foreach ($blog->getAsphalting() as $asphalt){

                        $url = $this->router->generate('asphalt_single', array('slugType' => $blog->getSlug(), 'slugAsphalt'=>$asphalt->getSlug()), true);

                        $blogUpdatedDate = $asphalt->getUpdated()->format("Y-m-d H:i:s");
                        $this->createSitemapEntry($url, new \DateTime($blogUpdatedDate), UrlConcrete::CHANGEFREQ_YEARLY, 0.8);

                    }


                }
            }

            foreach ($equipment as $blog) {

                $url = $this->router->generate('asphalt_type', array('slug' => $blog['slug']), true);

                $blogUpdatedDate = $blog['updated']->format("Y-m-d H:i:s");
                $this->createSitemapEntry($url, new \DateTime($blogUpdatedDate), UrlConcrete::CHANGEFREQ_YEARLY, 0.8);
            }


        }
    }

    private function createSitemapEntry($url, $modifiedDate, $changeFrequency, $priority)
    {
        //add homepage url to the urlset named default
        $this->event->getGenerator()->addUrl(
            new UrlConcrete(
                $url,
                $modifiedDate,
                $changeFrequency,
                $priority
            ),
            'default'
        );
    }
}

