<?php

/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 5/29/17
 * Time: 1:02 PM
 */

namespace AppBundle\Block;

use Sonata\AdminBundle\Admin\Pool;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomMosaicAdminBlock extends AbstractBlockService
{
    protected $pool;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param Pool            $pool
     */
    public function __construct($name, EngineInterface $templating, Pool $pool)
    {
        parent::__construct($name, $templating);

        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $dashboardGroups = $this->pool->getDashboardGroups();

        $settings = $blockContext->getSettings();

        $admins = [];
        $visibleGroups = array();
        foreach ($dashboardGroups as $name => $dashboardGroup) {
            if (!$settings['groups'] || in_array($name, $settings['groups'])) {
                $visibleGroups[] = $dashboardGroup;
            }

            if($settings['groups'][0] == $name){
                foreach ($dashboardGroups[$name]['items'] as $item){
                    $admins[] = $item;
                }
            }
        }

        return $this->renderPrivateResponse(
            'AppBundle:AdminMenu:list_outer_rows_mosaic_custom.html.twig',
                array(
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'admin_pool' => $this->pool,
            'groups' => $visibleGroups,
            'admins'=>$admins
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Admin List';
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'groups' => false,
        ));

        // Symfony < 2.6 BC
        if (method_exists($resolver, 'setNormalizer')) {
            $resolver->setAllowedTypes('groups', array('bool', 'array'));
        } else {
            $resolver->setAllowedTypes(array(
                'groups' => array('bool', 'array'),
            ));
        }
    }
}