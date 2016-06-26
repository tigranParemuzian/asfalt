<?php

/**
 * Created by PhpStorm.
 * User: developer-01
 * Date: 3/11/16
 * Time: 1:27 PM
 */
namespace AppBundle\Admin;

use AppBundle\Entity\Item;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MenuAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->tab('General')
                ->with('General')
                    ->add('name', null, array('label' => 'Name'))
                    ->add('position')
                    ->add('title')
                    ->add('description', 'textarea')
                    ->add('article')
                ->end()
                ->end()
                ->tab('Meta data')
                ->with('Meta data')
                    ->add('metaTitle')
                    ->add('metaDescription')
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('slug')
            ->add('title')
            ->add('position')
            ->add('article')
            ->add('description')
            ->add('metaTitle')
            ->add('metaDescription')
            ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('slug')
            ->addIdentifier('title')
            ->add('position')
            ->add('article')
            ->addIdentifier('description')
            ->addIdentifier('metaTitle')
            ->addIdentifier('metaDescription')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )))
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('slug')
            ->add('title')
            ->add('position')
            ->add('article')
            ->add('description')
            ->add('metaTitle')
            ->add('metaDescription')
        ;
    }
}

