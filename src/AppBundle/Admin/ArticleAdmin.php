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

class ArticleAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->tab('General')
                ->with('General')
                    ->add('title')
                    ->add('icon', 'text', array('required'=>false,'help'=>'<p>For icons examples use <a href="http://madmin.swlabs.co/#/ui-icons" target="_blank"> Icons </a></p>'))
                    ->add('body', 'textarea', array('label' => 'Body'))
                    ->add('footer')
                    ->add('position')
                    ->add('groupName')
                    ->add('file', 'icon_type', array('required' => false, 'label'=>'Ad image'))
                    ->add('menu')
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('icon')
            ->add('body')
            ->add('footer')
            ->add('position')
            ->add('groupName')
            ->add('menu')
            ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->addIdentifier('icon')
            ->addIdentifier('body')
            ->addIdentifier('footer')
            ->addIdentifier('position')
            ->addIdentifier('groupName')
            ->add('fileOriginalName')
            ->add('menu')
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
            ->add('title')
            ->add('icon')
            ->add('body')
            ->add('footer')
            ->add('position')
            ->add('groupName')
            ->add('menu')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $object->uploadFile();
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $object->uploadFile();
    }
}

