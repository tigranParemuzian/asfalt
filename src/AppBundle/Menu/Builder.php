<?php

namespace AppBundle\Menu;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class Builder
 * @package AppBundle\Menu
 */
class Builder extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $menuLinks = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Menu')->findMenu();

        $menu = $factory->createItem('root');

        foreach($menuLinks as $menuLink)
        {
//            dump($menuLink->getName()); exit;
            $menu->addChild($menuLink->getName())
                ->setUri('#' . $menuLink->getSlug())

//            , array('route' => 'singlePage', 'routeParameters'=>array('slug'=>$menuLink->getSlug())))
                ;
        }

        return $menu;
    }
}
