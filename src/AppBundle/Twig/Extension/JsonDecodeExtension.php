<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class JsonDecodeExtension extends Twig_Extension
{
    public function getName()
    {
        return 'some.extension';
    }

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('json_decode', array($this, 'jsonDecode'))
        );
    }

    public function jsonDecode($str) {
//        dump($str); exit;
        return json_decode($str, true);
    }
}
