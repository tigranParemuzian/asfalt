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

class ContactType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name', 'text', ['label'=>false, 'required'=>true, 'attr'=>['placeholder'=>'Имя', 'class'=>'input-lg']])
            ->add('email', 'email', ['label'=>false, 'required'=>true, 'attr'=>['placeholder'=>'Эл. адрес', 'class'=>'input-lg']])
            ->add('phone', 'text', ['label'=>false, 'required'=>false, 'attr'=>['placeholder'=>'Телефон', 'class'=>'input-lg']])
            ->add('message', 'textarea', ['label'=>false, 'required'=>true, 'attr'=>['placeholder'=>'Сообщение', 'class'=>'input-lg mtm']])
//            ->add('send', 'submit', ['attr'=>['class'=>'btn btn1']])
            ;


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_contact';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_contact';
    }

}
