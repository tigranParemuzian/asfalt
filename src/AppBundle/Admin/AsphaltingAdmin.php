<?php
/**
 * Created by PhpStorm.
 * User: parem
 * Date: 1/17/17
 * Time: 1:11 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Asphalting;
use AppBundle\Entity\Booking;
use AppBundle\Entity\ProductItem;
use AppBundle\Entity\Settings;
use AppBundle\Form\IconType;
use AppBundle\Form\ParametersType;
use AppBundle\Form\SettingsType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class AsphaltingAdmin extends Admin
{

    private $settings;
    private $em;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'id' // field name
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('project_show');
        $collection->add('clone', 'clone/{objectId}/{count}');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $className = $this->getSubject()->getClassName();

        $item = $this->getSubject();

        $container = $this->getConfigurationPool()->getContainer();

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
                'class' =>'col-sm-6' ,
                'box-class' => 'box box-solid box-denger',
                'description'=>'Main main create part'
            ))
            ->add('name')
            ->add('type')
            ->add('state', 'choice', ['choices'=>
                [
                    'New'=>Asphalting::IS_NEW,
                    'Top'=>Asphalting::IS_TOP,
                    'Disable'=>Asphalting::IS_DISABLED]])
            ->add('file', IconType::class, ['label'=>'Main image'])
            ->end()
        ;



        $formMapper->with('Marketing', array(
            'class' =>'col-sm-6',
            'box-class' => 'box box-solid box-danger',
            'description'=>'Marketing part'
        ))
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('metaDescription')
            ->end()
            ->with('Priceing', array(
                'class' =>'col-sm-6',
                'box-class' => 'box box-solid box-danger',
                'description'=>'Priceing part'
            ))
        ->add('price', 'sonata_type_collection', array(
//                'cascade_validation' => false,
                'type_options'       => array('delete' => true ),
            ), array(
                'edit'            => 'inline',
                'inline'          => 'table',
                'sortable'        => 'position',
                'link_parameters' => array( 'context' => 'define context from which you want to select media or else just add default' ),
                /*here provide service name for junction admin */
            ))
        ->end();

        if(!is_null($item->getId())){

            $formMapper->with('Settings', array(
                'class' =>'col-sm-6',
                'box-class' => 'box box-solid box-danger',
                'description'=>'Settings main create part'
            ))
                ->add('toSettings', 'collection', [
                    'entry_type' => SettingsType::class,
                    'entry_options'  => [
                        'attr'=>['class'=>'col-md-12'],
                        'from_id'=>$item->getId(), 'from_class_name'=>$className, 'container'=>$container
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
//                    'cascade_validation' => true,
                    'by_reference' => true,
                    'delete_empty' => true,
                    'mapped' => false,
                    'data' => $item->getFromSettings(),
                    'label' => ' ',
                    'required'=>false,
//                    'options' => array('label' => ' ', 'sortable'=>true),
                    'attr' => ['class' => 'col-sm-12 sortable']])
                ->end();
        }

        if(!is_null($item->getFromSettings())){
            $formMapper->with('Parameters', array(
                'class' =>'col-sm-6',
                'box-class' => 'box box-solid box-danger',
                'description'=>'Settings main create part'
            ))
                ->add('fromSettings', ParametersType::class, ['from_id'=>$item->getId(), 'from_class_name'=>$className, 'container'=>$container,
                    'data'=>$settings, 'mapped' => false, 'label_attr'=>['class'=>'hidden']])
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
            ->add('name')
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('metaDescription')
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
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('metaDescription')
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
            ->add('unit')
            ->add('state')
            ->add('price')
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('metaDescription')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {

        if($object->getFile()){
            $object->uploadFile();
        }
        if($object->getPrice()){
            foreach ($object->getPrice() as $item){
                $item->setAsphalt($object);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {

        if($object->getFile()){
            $object->uploadFile();
        }

        if($object->getPrice()){
            foreach ($object->getPrice() as $item){
                $item->setAsphalt($object);
            }
        }


    }
}