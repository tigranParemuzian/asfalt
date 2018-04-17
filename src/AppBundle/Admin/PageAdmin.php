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
use AppBundle\Form\ParametersType;
use AppBundle\Form\SettingsType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PageAdmin extends Admin
{

    private $settings;
    private $em;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'id' // field name
    );


    protected function configureFormFields(FormMapper $formMapper)
    {
        $className = $this->getSubject()->getClassName();

        $container = $this->getConfigurationPool()->getContainer();

        $item = $this->getSubject();

        $this->em = $container->get('doctrine')->getManager();

        $settings = null;
        if(!is_null($item->getId())){

            $settings = $this->em->getRepository('AppBundle:Settings')->findFrom($item->getId(), $className);
        }

        $this->settings = $settings;

    if(count($settings) > 0){
        foreach ($settings as $setting){

            $item->addFromSettings($setting);

        }
    }

        $formMapper
            ->with('Main', array(
                'class' =>!is_null($item->getId()) ? 'col-sm-6' :'col-sm-12' ,
                'box-class' => 'box box-solid box-danger',
                'description'=>'Main main create part'
            ))
            ->add('name')
            ->add('slug', null, ['required'=>false])
            ->end()
        ;
        if(!is_null($item->getId())){

        $formMapper->with('Settings', array(
            'class' =>'col-sm-6',
            'box-class' => 'box box-solid box-danger',
            'description'=>'Settings main create part'
        ))
            ->add('toSettings', 'collection', [
                'entry_type' => SettingsType::class ,
                'entry_options'  => [
                    'attr'=>['class'=>'col-md-12'], 'container'=>$container,
                    'from_id'=>$item->getId(), 'from_class_name'=>$className
                ],
                'allow_add' => true,
                'allow_delete' => true,
//                'cascade_validation' => true,
                'by_reference' => true,
                'delete_empty' => true,
                'mapped' => false,
                'data' => $item->getFromSettings(),
                'label' => ' ',
                'required'=>false,
//                'options' => array('label' => ' ', 'sortable'=>true),
                'attr' => ['class' => 'col-sm-12 sortable']])
            ->end();
        }

        if(!is_null($item->getFromSettings())){
            $formMapper->with('Parameters', array(
                'class' =>'col-sm-12',
                'box-class' => 'box box-solid box-danger',
                'description'=>'Settings main create part'
            ))
                ->add('fromSettings', ParametersType::class, ['container'=>$container,'from_id'=>$item->getId(), 'from_class_name'=>$className,
                    'data'=>$settings, 'mapped' => false, 'label_attr'=>['class'=>'hidden'], 'attr'=>['is_document'=>true]])
                ->end()
                ->end();
        }

    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('name', 'tetx', ['editable'=>true])
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
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {

        $toSettings = (array)$this->getForm()->get('toSettings')->getData();
        if(!is_null($this->settings) && (count($this->settings) > count($toSettings))){
            foreach ($this->settings as $key=>$val){
                if(!array_key_exists($key, $toSettings)){
                    $this->em->remove($val);
                    $this->em->remove($this->em->getRepository($val->getToClassName())->find($val->getToId()));
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {

    }
}