<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 9/14/17
 * Time: 11:54 PM
 */

namespace AppBundle\Service;



use AppBundle\Entity\Boolean;
use AppBundle\Entity\Date;
use AppBundle\Entity\Document;
use AppBundle\Entity\DocumentsList;
use AppBundle\Entity\File;
use AppBundle\Entity\Settings;
use AppBundle\Entity\Text;
use AppBundle\Model\AttributeInterface;
use AppBundle\Model\MainObjectabeleInterface;
use Symfony\Component\DependencyInjection\Container;

class CRUDDocunets
{

    private $container;
    private $em;
    private $toClasses = [];
    private $toTypes = [];
    private $fromClasses = [];

    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->em = $container->get('doctrine')->getManager();

        $this->toClasses = [
                Settings::IS_DOCUMENT=>'AppBundle\Entity\Document',
                Settings::IS_DOCUMENTS_LIST=>'AppBundle\Entity\DocumentsList',
                Settings::IS_TEXT=>'AppBundle\Entity\Text',
                Settings::IS_TEXT_AREA=>'AppBundle\Entity\Text',
                Settings::IS_BOOLEAN=>'AppBundle\Entity\Boolean',
                Settings::IS_IMAGE=>'AppBundle\Entity\File',
                Settings::IS_VIDEO=>'AppBundle\Entity\File',
                Settings::IS_FILE=>'AppBundle\Entity\File',
                Settings::IS_DATE=>'AppBundle\Entity\Date',
                Settings::IS_GALLERY=>'AppBundle\Entity\DocumentsList',
        ];

        $this->toTypes = [
            Settings::IS_GALLERY=>'gallery',
            Settings::IS_TEXT=>'text',
            Settings::IS_TEXT_AREA=>'textarea',
            Settings::IS_IMAGE=>'image',
            Settings::IS_VIDEO=>'video',
            Settings::IS_FILE=>'file',
            Settings::IS_DOCUMENT=>'document',
            Settings::IS_DOCUMENTS_LIST=>'document-list'
            ];
    }

    public function createDocument(Settings $settings){

        $uow = $this->em->getUnitOfWork();

        $uow->computeChangeSets(); // do not compute changes if inside a listener

        if(is_null($settings->getToClassName()) || is_null($settings->getToId())){

            $parent = new $this->toClasses[$settings->getToClassType()];

            if($parent instanceof AttributeInterface){
                array_key_exists($settings->getToClassType(), $this->toTypes) ? $parent->setFormType($this->toTypes[$settings->getToClassType()]) : '';
                $parent->setTitle($settings->getName());
                $parent->setSortOrdering($settings->getPosition());

                $this->em->persist($parent);
            }

        }else {

            if(!is_null($settings->getToId())){

                $changeset = $uow->getEntityChangeSet($settings);




                    if(array_key_exists('toClassType', $changeset)){


                        $toObject= $this->em->getRepository($this->toClasses[$changeset['toClassType'][0]])->find($settings->getToId());

                        $this->em->remove($toObject);

                        $parent = new $this->toClasses[$settings->getToClassType()];

                        if($parent instanceof AttributeInterface){
                            array_key_exists($settings->getToClassType(), $this->toTypes) ? $parent->setFormType($this->toTypes[$settings->getToClassType()]) : '';
                            $parent->setTitle($settings->getName());
                            $parent->setSortOrdering($settings->getPosition());

                            $this->em->persist($parent);
                        }


                    }else {

                        if(array_key_exists('name', $changeset)){

                            $parent= $this->em->getRepository($this->toClasses[$settings->getToClassType()])->find($settings->getToId());

                            if($parent && $parent instanceof AttributeInterface){
                                $parent->setTitle($settings->getName());
                                $parent->setSortOrdering($settings->getPosition());

                                $this->em->persist($parent);

                            }
                        }
                    }

            }
        }


        $this->em->flush();

        $settings->setToClassName($this->toClasses[$settings->getToClassType()]);
        isset($parent) ? $settings->setToId($parent->getId()):'';

        $this->em->persist($settings);
        $this->em->flush();

        return $settings;
    }

    public function getObjectTypes(){
        return $this->toClasses;
    }

    public function getTypes(){
        return $this->toTypes;
    }

    public function getFromClasses(){
        return $this->fromClasses;
    }
}