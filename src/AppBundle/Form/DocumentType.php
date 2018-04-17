<?php

namespace AppBundle\Form;

use AppBundle\Entity\Settings;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    private $container;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $data = $options['data'];

        $this->container = $options['container'];
        $settings = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Settings')->findFrom($data->getId(), $options['data_class']);

        if(!is_null($settings)){
            foreach ($settings as $setting){
            $data->addFromSettings($setting);
        }
            $builder
                ->add('fromSettings', ParametersType::class, ['from_id'=>$data->getId(), 'container'=>$this->container, 'from_class_name'=> $options['data_class'],
                    'data'=>$settings, 'mapped' => false,]);
        }



        $builder
            ->add('title', 'hidden')
            ->add('slug', 'hidden')
            ->add('sortOrdering', 'hidden')
            ->add('created')
            ->add('updated')
            ->add('formType', 'hidden');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document',
            'form_type_text'=>null,
            'container'=>null,
            /*'object_id'=>null,
            'object_name'=>null,*/

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_document';
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_bundle_document';
    }


}
