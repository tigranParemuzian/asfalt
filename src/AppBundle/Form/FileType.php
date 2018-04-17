<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('state', null, ['label'=>'Active'])
            ->add('file', $options['form_type_text'])
            ->add('fileOriginalName', 'hidden')
            ->add('fileName', 'hidden')
            ->add('title', 'hidden')
            ->add('slug', 'hidden')
            ->add('sortOrdering', 'hidden')
            ->add('created')
            ->add('updated')
            ->add('formType', 'hidden')
            ->addModelTransformer(new CallbackTransformer(

                function ($tagsAsArray) {
                    // transform the array to a string
                    return $tagsAsArray;
                },
                function ($beforeParsist) {
//                    if(!is_null($beforeParsist->file)){
                        $beforeParsist->uploadFile();
//                    }

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
            'data_class' => 'AppBundle\Entity\File',
            'form_type_text'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_file';
    }

    public function getName()
    {
        return 'app_bundle_file';
    }

}
