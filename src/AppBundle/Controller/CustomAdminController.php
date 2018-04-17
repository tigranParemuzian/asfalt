<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 9/18/17
 * Time: 2:27 AM
 */

namespace AppBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController;

class CustomAdminController extends CRUDController
{

    /**
     * @return RedirectResponse
     */
    public function cloneAction($objectId, $count)
    {
        if((int)$objectId <0 || (int)$count <= 0){

            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $objectId));
        }

        $object = $this->admin->getObject($objectId);


        do{
            $clonedObject = clone $object;

            if($clonedObject instanceof ProductStorage){

                $clonedObject->setUser($this->getUser());
            }

            $this->admin->create($clonedObject);
            $count --;
        }while($count);


        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateObjectUrl('list', $clonedObject));
    }

}