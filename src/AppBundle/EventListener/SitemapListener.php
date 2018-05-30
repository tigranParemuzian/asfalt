<?php
/**
 * Created by PhpStorm.
 * User: armen
 * Date: 10/21/15
 * Time: 5:26 PM
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapListener implements EventSubscriberInterface
{

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ManagerRegistry       $doctrine
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ManagerRegistry $doctrine)
    {
        $this->urlGenerator = $urlGenerator;
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'main',
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'main',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function main(SitemapPopulateEvent $event)
    {
        $this->registerBlogPostsUrls($event->getUrlContainer());
    }


    /**
     * @param UrlContainerInterface $urls
     */
    public function registerBlogPostsUrls(UrlContainerInterface $urls)
    {
        $posts = $this->doctrine->getRepository('AppBundle:AsphaltingTypes')->findAllForSitemap();
        $equipments = $this->doctrine->getRepository('AppBundle:EquipmentTypes')->findAllForParent();

        foreach ($posts as $post) {

            $urls->addUrl(
                new UrlConcrete(

                    $this->urlGenerator->generate(
                        'asphalt_type',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'main'
            );
        }

        foreach ($equipments as $post) {

            $urls->addUrl(
                new UrlConcrete(

                    $this->urlGenerator->generate(
                        'asphalt_type',
                        ['slug' => $post['slug']],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'main'
            );
        }
    }
}

