<?php
/**
 * Created by PhpStorm.
 * User: parem
 * Date: 1/17/17
 * Time: 1:11 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Booking;
use AppBundle\Entity\ProductItem;
use AppBundle\Entity\Settings;
use AppBundle\Form\SettingsType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class AsphaltingPriceAdmin extends Admin
{

    private $settings;
    private $em;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'id' // field name
    );

//    protected function configureRoutes(RouteCollection $collection)
//    {
//        parent::configureRoutes($collection);
//        $collection->add('project_show');
//        $collection->add('clone', 'clone/{objectId}/{count}');
//    }

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('Main', array(
                'class' =>'col-sm-6' ,
                'box-class' => 'box box-solid box-denger',
                'description'=>'Main create part'
            ))
            ->add('value')
            ->add('unit', null, ['required'=>false])
            ->add('layer', null, ['required'=>false])
            ->add('description')
            ->end()

            /*->with('Description', array(
                'class' =>'col-sm-6' ,
                'box-class' => 'box box-solid box-denger',
                'description'=>'Description create part'
            ))
            ->add('description')
            ->end()*/
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('name')
            ->add('state')
            ->add('_action', 'actions',
                array('actions'=>
                    array(
                        'show'=>array(), 'edit'=>array(), 'delete'=>array())
                ))
        ;

    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('state')
            ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('name')
            ->add('state')
            ->add('description')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {

//        $toSettings = (array)$this->getForm()->get('toSettings')->getData();
//        if(!is_null($this->settings) && (count($this->settings) > count($toSettings))){
//            foreach ($this->settings as $key=>$val){
//                if(!array_key_exists($key, $toSettings)){
//                    $this->em->remove($val);
//                    $this->em->remove($this->em->getRepository($val->getToClassName())->find($val->getToId()));
//                }
//            }
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {

    }
}