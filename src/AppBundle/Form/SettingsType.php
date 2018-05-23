<?php

namespace AppBundle\Form;

use AppBundle\Entity\Settings;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{

    private $container;
    private $i;
    private $toClassType;

    public function __construct()
    {
        $this->i =0;
        $this->toClassType = [
            'AppBundle\Entity\Pages'=>[
                'Document'=>Settings::IS_DOCUMENT,
                'Documents list'=>Settings::IS_DOCUMENTS_LIST,
                'Text'=>Settings::IS_TEXT,
                'Long text'=>Settings::IS_TEXT_AREA,
                'On/Off'=>Settings::IS_BOOLEAN,
                'File'=>Settings::IS_FILE,
                'Image'=>Settings::IS_IMAGE,
                'Video'=>Settings::IS_VIDEO,
                'Date'=>Settings::IS_DATE,
                'Gallery'=>Settings::IS_GALLERY
            ],
            'AppBundle\Entity\Document'=>[
                'Text'=>Settings::IS_TEXT,
                'Long text'=>Settings::IS_TEXT_AREA,
                'On/Off'=>Settings::IS_BOOLEAN,
                'File'=>Settings::IS_FILE,
                'Image'=>Settings::IS_IMAGE,
                'Video'=>Settings::IS_VIDEO,
                'Date'=>Settings::IS_DATE,
                'Gallery'=>Settings::IS_GALLERY
            ],
            'AppBundle\Entity\Products'=>[
                'Text'=>Settings::IS_TEXT,
                'Long text'=>Settings::IS_TEXT_AREA,
                'On/Off'=>Settings::IS_BOOLEAN,
                'File'=>Settings::IS_FILE,
                'Image'=>Settings::IS_IMAGE,
                'Video'=>Settings::IS_VIDEO,
                'Date'=>Settings::IS_DATE,
                'Gallery'=>Settings::IS_GALLERY
            ],
            'AppBundle\Entity\Projects'=>[
                'Documents list'=>Settings::IS_DOCUMENTS_LIST,
                'Text'=>Settings::IS_TEXT,
                'Long text'=>Settings::IS_TEXT_AREA,
                'On/Off'=>Settings::IS_BOOLEAN,
                'File'=>Settings::IS_FILE,
                'Image'=>Settings::IS_IMAGE,
                'Video'=>Settings::IS_VIDEO,
                'Date'=>Settings::IS_DATE,
                'Gallery'=>Settings::IS_GALLERY,
                'Link'=>Settings::IS_URL ],
            'AppBundle\Entity\DocumentsList'=>[
                'Document'=>Settings::IS_DOCUMENT,
                'Text'=>Settings::IS_TEXT,
                'Long text'=>Settings::IS_TEXT_AREA,
                'On/Off'=>Settings::IS_BOOLEAN,
                'File'=>Settings::IS_FILE,
                'Image'=>Settings::IS_IMAGE,
                'Video'=>Settings::IS_VIDEO,
                'Date'=>Settings::IS_DATE,
                'Gallery'=>Settings::IS_GALLERY
            ]


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->container = $options['container'];

        $builder->add('name')
            ->add('toClassType', 'choice', ['choices'=>
                isset($this->toClassType[$options['from_class_name']]) ? $this->toClassType[$options['from_class_name']] :
                    ['Document'=>Settings::IS_DOCUMENT,
                        'Documents list'=>Settings::IS_DOCUMENTS_LIST,
                        'Text'=>Settings::IS_TEXT,
                        'Long text'=>Settings::IS_TEXT_AREA,
                        'On/Off'=>Settings::IS_BOOLEAN,
                        'File'=>Settings::IS_FILE,
                        'Image'=>Settings::IS_IMAGE,
                        'Video'=>Settings::IS_VIDEO,
                        'Date'=>Settings::IS_DATE,
                        'Gallery'=>Settings::IS_GALLERY]
            ])
            ->add('position', 'hidden', ['data'=>$this->i, 'attr'=>['sortable'=>1]])
            ->add('inEnabled')
            ->add('fromId', 'hidden', ['data'=>(int)$options['from_id']])
            ->add('toId', 'hidden')
            ->add('fromClassName', 'hidden', ['data'=>$options['from_class_name']])
            ->add('toClassName', 'hidden')

            ->addModelTransformer(new CallbackTransformer(

                function ($tagsAsArray) {
                    // transform the array to a string
                    return $tagsAsArray;
                },
                function ($beforeParsist) {

                    $this->i ++;
                    if((int)$beforeParsist->getPosition() == 0){
                        $beforeParsist->setPosition($this->i);
                    }

                    if($beforeParsist->getFromClassName() && $beforeParsist->getToClassType() >=0 && $beforeParsist->getFromId()){
                        $beforeParsist = $this->container->get('app.document.settings')->createDocument($beforeParsist, $this->i);
                    }

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
            'data_class' => 'AppBundle\Entity\Settings',
            'from_id'=>null,
            'from_class_name'=>null,
            'container'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_settings';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_settings_type';
    }
}
