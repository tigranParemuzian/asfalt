<?php

namespace AppBundle\Form;

use AppBundle\Entity\Settings;
use AppBundle\Entity\Text;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formType = $options['form_type_text'];

        $textOptions = ['label'=>false, 'required' => false];
        if($formType == 'ckeditor'){
            $textOptions = array_merge($textOptions, [
                'trim' => true,
                'auto_inline'=>true,
                'config' => array(
                    'uiColor' => '#ffffff',
                    'required'=>true)]) ;
        }

        $builder->add('value', $formType, $textOptions
                    )
            ->add('title', 'hidden')
            ->add('slug', 'hidden')
            ->add('sortOrdering', 'hidden')
            ->add('formType', 'hidden')
            ->addModelTransformer(new CallbackTransformer(

                function ($tagsAsArray) {
                    // transform the array to a string
                    return $tagsAsArray;
                },
                function ($beforeParsist) {

                   /* dump($beforeParsist);

                    $log = $this->container->get('monolog.logger.process_error');

                    $message = $beforeParsist->getId() . '-' . $beforeParsist->getValue();
                    $log->addInfo("dataText : {$message}");

                    $this->em->persist($beforeParsist);
                    $this->em->flush();*/

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
            'data_class' => 'AppBundle\Entity\Text',
            'form_type_text'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_text';
    }

}
