<?php
namespace AppBundle\Form;
use AppBundle\Entity\MenuItom;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class IconType extends AbstractType
{
    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'file';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'icon_type';
    }

//    /**
//     * @param OptionsResolver $resolver
//     */
//    public function setDefaultOptions(OptionsResolver $optionsResolver)
//    {
//        parent::configureOptions($optionsResolver);
//
//        $optionsResolver->setDefaults(array(
//            'data_class' => 'AppBundle\Trade\Documents'
//        ));
//    }
}