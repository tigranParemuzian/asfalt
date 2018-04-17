<?php

namespace AppBundle\Form;

use AppBundle\Entity\Settings;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametersType extends AbstractType
{

    private $container;
    private $i;
    private $toClassType;
    private $settingsFormTypes;

    public function __construct()
    {
        $this->i =0;
        $this->toClassType = [
            'AppBundle\Entity\Pages'=>[Settings::IS_DOCUMENT=>'Document', Settings::IS_DOCUMENTS_LIST=>'Documents list', Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video'],
            'AppBundle\Entity\Document'=>[Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video'],
            'AppBundle\Entity\DocumentsList'=>[Settings::IS_DOCUMENT=>'Document',Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video']


        ];

        $this->settingsFormTypes = [
            'AppBundle\Entity\Pages'=>[Settings::IS_DOCUMENT=>'Document', Settings::IS_DOCUMENTS_LIST=>'Documents list', Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video'],
            'AppBundle\Entity\Document'=>[Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video'],
            'AppBundle\Entity\DocumentsList'=>[Settings::IS_DOCUMENT=>'Document',Settings::IS_TEXT=>'Text', Settings::IS_TEXT_AREA=>'Long text',
                Settings::IS_BOOLEAN=>'On/Off', Settings::IS_FILE=>'File', Settings::IS_IMAGE=>'Image', Settings::IS_VIDEO=>'Video']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->container = $options['container'];

        $datas = $options['data'];


        foreach ($datas as $key=>$data){

            if($data instanceof Settings){

                $data->getToClassType();

                $objetc = $this->container->get('doctrine')->getManager()->getRepository($data->getToClassName())->find($data->getToId());

                $em = $this->container->get('doctrine')->getManager();

                if($data->getToClassType() === Settings::IS_TEXT){

                    $builder->add($data->getSlug(),TextType::class,
                        [
                            'label'=>$data->getName(),
                            'data'=>$objetc,
                            'form_type_text'=>'text',
                            'mapped'=>false,
                            'required'=>false,
                            'attr'=>['class'=>'col-md-12']
                        ]);
                }

                if ($data->getToClassType() === Settings::IS_TEXT_AREA){
                    $builder->add($data->getSlug(), TextType::class,
                        [
                            'label'=>$data->getName(),
                            'data'=>$objetc,
                            'form_type_text'=>CKEditorType::class,
                            'required'=>false,
                            'mapped'=>false,
                            'attr'=>['class'=>'col-md-12']
                            ]);
                }

                if ($data->getToClassType() === Settings::IS_DOCUMENT){

                    $builder->add($data->getSlug(), DocumentType::class,
                        [
                            'label'=>$data->getName(),
                            'data'=>$objetc,
                            'form_type_text'=>'textarea',
                            'container'=>$this->container,
                            'mapped'=>false,
                            'required'=>false,
                            'label_attr'=>['class'=>'text-info'],
                            'attr'=>['is_document'=>true]
                        ]);
                }

                if ($data->getToClassType() === Settings::IS_DOCUMENTS_LIST){

                    $builder->add($data->getSlug(), DocumentsListType::class,
                        [
                            'label'=>$data->getName(),
                            'data'=>$objetc,
                            'form_type_text'=>'textarea',
                            'container'=>$this->container,
                            'mapped'=>false,
                            'required'=>false,
                            'label_attr'=>['class'=>'text-info']
                        ]);
                }

                if ($data->getToClassType() === Settings::IS_GALLERY){

                    $builder->add($data->getSlug(), DocumentsListType::class,
                        [
                            'label'=>$data->getName(),
                            'data'=>$objetc,
                            'form_type_text'=>'textarea',
                            'container'=>$this->container,
                            'mapped'=>false,
                            'required'=>false,
                            'label_attr'=>['class'=>'text-info']
                        ]);
                }

                if ($data->getToClassType() === Settings::IS_IMAGE){

                    $builder->add($data->getSlug(), FileType::class, ['label'=>$data->getName(),
                        'required'=>false, 'data'=>$objetc,
                        'form_type_text'=>IconType::class,'mapped'=>false]);
                }

                if ($data->getToClassType() === Settings::IS_FILE){

                    $builder->add($data->getSlug(), FileType::class, ['label'=>$data->getName(),
                        'required'=>false, 'data'=>$objetc,
                        'form_type_text'=>'file_form_type','mapped'=>false]);
                }
            }

        }

        $builder->addModelTransformer(new CallbackTransformer(

            function ($tagsAsArray) {
                // transform the array to a string
                return $tagsAsArray;
            },
            function ($beforeParsist) {

                // transform the string back to an array
                return $beforeParsist;
            }
        ))
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Settings',
            'from_id'=>null,
            'from_class_name'=>null,
            'container'=>null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_parameters';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_parameters';
    }

}
