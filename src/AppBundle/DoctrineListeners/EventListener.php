<?php
/**
 * Created by PhpStorm.
 * User: andranik
 * Date: 9/19/14
 * Time: 2:11 PM
 */

namespace AppBundle\DoctrineListeners;

use AppBundle\Entity\AttributesDefinition;
use AppBundle\Entity\Campaign;
use AppBundle\Entity\CollectionValues;
use AppBundle\Entity\Date;
use AppBundle\Entity\File;
use AppBundle\Entity\ListValues;
use AppBundle\Entity\Page;
use AppBundle\Entity\Project;
use AppBundle\Model\AttributabeleInterface;
use AppBundle\Model\AttributeInterface;
use AppBundle\Model\ConfiguratorInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Process\Process;

class EventListener
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        // get entityManager
		$em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $env = $this->container->get( 'kernel' )->getEnvironment();
            $updatedNames = ['Timeline', 'Start Date'];

        // check updates
        $i = 0;

        $mainDir = str_replace('/app', '/', $this->container->getParameter('kernel.root_dir'));

        foreach($uow->getScheduledEntityInsertions() as $entity)
        {

            if($entity instanceof AttributabeleInterface){

                if($entity->getBelongsTo() instanceof Campaign){
                    $belongsToObject = AttributesDefinition::IS_CAMPAIGN;
                } elseif ($entity->getBelongsTo() instanceof Project){
                    $belongsToObject = AttributesDefinition::IS_PROJECT;
                } elseif ($entity->getBelongsTo() instanceof Page){
                    $belongsToObject = AttributesDefinition::IS_PAGE;
                }elseif ($entity->getBelongsTo() instanceof ListValues){
                    $belongsToObject = AttributesDefinition::IS_LIST;
                }
                $attrClass = $entity->getAttributesDefinition()->getAttrClass();
                $attrName = $entity->getAttributesDefinition()->getAttrName();
                $belongsToObjectId = $entity->getBelongsTo()->getId();
                $sortOrdering = $entity->getSortOrdering();
                $formType = 'text';

                if(strpos($entity->getAttributesDefinition()->getSlug(),'member-position') !== false){
                    $formType = 'choice-members';
                }
                if (strpos($entity->getAttributesDefinition()->getSlug(),'about-interviewer') !== false){
                    $formType = 'ckeditor';
                }
                $t = strpos('about-interviewer', 'about-interviewer-1');
                $seesionInfo = $this->container->get('session')->get('cloning');

                $log = $this->container->get('monolog.logger.process_error');

                $log->addInfo("s:{$t} {$entity->getAttributesDefinition()->getSlug()} {$attrClass} {$belongsToObjectId} {$belongsToObject} {$attrName} {$sortOrdering} {$formType}");

                if((int)$seesionInfo != 1){
                    $attrName = str_replace(' ', '_', $attrName);
                    $now = new \DateTime('now');
                    $now = $now->format('Y-m-d h:i:s');
                    $inter = md5($now.$i);
                    $process = new Process("cd $mainDir && app/console  app:create_document_command {$inter} {$attrClass} {$belongsToObjectId} {$belongsToObject} {$attrName} {$sortOrdering} {$formType}");
                    // send process to background
                    $process->start();
                }

            }

            if ($entity instanceof ListValues && !is_null($entity->getCollectionValues()) && !is_null($entity->getCollectionValues()->getId())){

                $firstList =$entity->getCollectionValues()->getListValues()->first();
                $firstId = $firstList->getId();
                $seesionInfo = $this->container->get('session')->get('cloning');

                if((int)$seesionInfo != 1) {
                    $now = new \DateTime('now');
                    $now = $now->format('Y-m-d h:i:s');
                    $inter = md5($now . $entity->getCollectionValues()->getId());
                    $process = new Process("cd $mainDir && app/console  app:list_settings_create_command {$inter} {$firstId}");
                    $process->start();
                }
            }

            if($entity instanceof Date){
                if(in_array($entity->getTitle(), $updatedNames)){
                    $seesionInfo = $this->container->get('session')->get('cloning');
                    (int)$seesionInfo != 1 ? $em->getRepository('AppBundle:Project')->updateInfo((int)$entity->getBelongsToObject()->getBelongsToObject(), $entity->getValue()->format('Y-m-d h:i:s')):'';
                }
            }

            apc_clear_cache('user');
        }

        foreach($uow->getScheduledEntityUpdates() as $entity)
        {

            if($entity instanceof Date){

                if($entity->getBelongsToObject()->getBelongsToObjectName() === AttributesDefinition::IS_PROJECT ||
                    (!is_null($entity->getBelongsToObject()->getCollectionValues()) &&
                        $entity->getBelongsToObject()->getCollectionValues()->getBelongsToObjectName() === AttributesDefinition::IS_PROJECT)){
                    if(in_array($entity->getTitle(), $updatedNames)){
                        $em->getRepository('AppBundle:Project')->updateInfo((int)$entity->getBelongsToObject()->getBelongsToObject(), $entity->getValue()->format('Y-m-d h:i:s'));
                    }
                };
            }
            if($entity instanceof AttributabeleInterface){

                $getChanged = $em->getUnitOfWork()->getEntityChangeSet($entity->getAttributesDefinition());

                    if($entity->getBelongsTo() instanceof ConfiguratorInterface){

                        $belongsToObjectName = '';
                        $belongsToObjectId = $entity->getBelongsTo()->getId();
                        if(strpos($entity->getBelongsTo()->getClassName(), AttributesDefinition::IS_PAGE) !== false){
                            $belongsToObjectName = AttributesDefinition::IS_PAGE;
                        }elseif (strpos($entity->getBelongsTo()->getClassName(), AttributesDefinition::IS_CAMPAIGN) !== false){
                            $belongsToObjectName = AttributesDefinition::IS_CAMPAIGN;
                        }elseif (strpos($entity->getBelongsTo()->getClassName(), AttributesDefinition::IS_PROJECT) !== false){
                            $belongsToObjectName = AttributesDefinition::IS_PROJECT;
                        }elseif (strpos($entity->getBelongsTo()->getClassName(), AttributesDefinition::IS_LIST) !== false){
                            $belongsToObjectName = AttributesDefinition::IS_LIST;
                        }

                        if(isset($getChanged['attrName'])){


                            if($belongsToObjectName == AttributesDefinition::IS_LIST){

                                $obj =$entity->getBelongsTo();

                                if($obj->getCollectionValues()){
                                    foreach ($obj->getCollectionValues()->getListValues() as $listValue){
                                        try {

                                            $em->getRepository('AppBundle:'.$entity->getAttributesDefinition()->getAttrClass())->updateByAttributesDefinition($getChanged['attrName'][0], $getChanged['attrName'][1],
                                                $listValue->getId());
                                        }catch(\Exception $e){
                                            $log = $this->container->get('monolog.logger.process_error');
                                            $log->addInfo("Request Can`t update attr name : {$e->getMessage()}\r\n");
                                        }
                                    }
                                }elseif($obj->getBelongsToObjectName() == AttributesDefinition::IS_PROJECT || $obj->getBelongsToObjectName() == AttributesDefinition::IS_CAMPAIGN ){

                                    $listValues = $em->getRepository('AppBundle:ListValues')->findBy(['belongsToObjectName'=>$obj->getBelongsToObjectName(),
                                         'name'=>$obj->getName()]);

                                    foreach ($listValues as $listValue){

                                        try {

                                            $em->getRepository('AppBundle:'.$entity->getAttributesDefinition()->getAttrClass())->updateByAttributesDefinition($getChanged['attrName'][0], $getChanged['attrName'][1],
                                                $listValue->getId());
                                        }catch(\Exception $e){
                                            $log = $this->container->get('monolog.logger.process_error');
                                            $log->addInfo("Request Can`t update attr name : {$e->getMessage()}\r\n");
                                        }
                                    }

                                }else{
                                    try {

                                        $em->getRepository('AppBundle:'.$entity->getAttributesDefinition()->getAttrClass())->updateByAttributesDefinition($getChanged['attrName'][0], $getChanged['attrName'][1],
                                            $obj->getId());
                                    }catch(\Exception $e){
                                        $log = $this->container->get('monolog.logger.process_error');
                                        $log->addInfo("Request Can`t update attr name : {$e->getMessage()}\r\n");
                                    }
                                }
                            }else{
                                try {

                                    $em->getRepository('AppBundle:'.$entity->getAttributesDefinition()->getAttrClass())->updateByAttributesDefinition($getChanged['attrName'][0], $getChanged['attrName'][1],
                                        $belongsToObjectName, $belongsToObjectId);
                                }catch(\Exception $e){
                                    $log = $this->container->get('monolog.logger.process_error');
                                    $log->addInfo("Request Can`t update attr name : {$e->getMessage()}\r\n");
                                }
                            }
                        }
                    }
            }
            apc_clear_cache('user');
        }

        // check data before remove Po data and remove data whose created during create it
        foreach($uow->getScheduledEntityDeletions() as $entity)
        {

            if($entity instanceof AttributesDefinition) {
                
            }

            if($entity instanceof AttributabeleInterface){
                $belongsTo = $entity->getBelongsTo();
                $entity->setBelongsTo(null);
                $entity->setAttributesDefinition(null);
                $em->detach($entity);
                $em->remove($entity);
            }
            if($entity instanceof ConfiguratorInterface){

                $belongsToObjectName = null;
                $belongsToObjectId = $entity->getId();
                if(strpos($entity->getClassName(), AttributesDefinition::IS_PAGE)){
                    $belongsToObjectName = AttributesDefinition::IS_PAGE;
                }elseif (strpos($entity->getClassName(), AttributesDefinition::IS_CAMPAIGN)){
                    $belongsToObjectName = AttributesDefinition::IS_CAMPAIGN;
                }elseif (strpos($entity->getClassName(), AttributesDefinition::IS_PROJECT)){
                    $belongsToObjectName = AttributesDefinition::IS_PROJECT;
                }

                if(!is_null($belongsToObjectName)){
                    $now = new \DateTime('now');
                    $now = $now->format('Y-m-d h:i:s');
                    $inter = md5($now.$i);

                    $process = new Process("cd $mainDir && app/console  app:remove_document_command {$inter} {$belongsToObjectId} {$belongsToObjectName}");
                    // send process to background
                    $process->start();
                }

            }

            apc_clear_cache('user');
        }
    }



}