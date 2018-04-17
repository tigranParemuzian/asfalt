<?php

namespace AppBundle\Controller\Rest;


use AppBundle\Entity\File;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdminController
 * @package AppBundle\Controller\Rest
 *
 * @RouteResource("Admin")
 * @Rest\Prefix("/api")
 * @Rest\NamePrefix("rest_")
 */
class AdminController extends FOSRestController
{

    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Admin",
     *  description="This function is used to get a all Articles.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getCloneAction(int $objectType, int $objectId)
    {
        $tyes = $this->get('app.document.settings')->getObjectTypes();

        $currentUser = $this->getUser();
        // check isset user and user security role
        if(!is_object($currentUser) && !$this->isGranted('ROLE_SONATA_ADMIN')) {
            $translated = $this->get('translator')->trans('erorrs.user.not_found');
            return new JsonResponse($translated , Response::HTTP_FORBIDDEN);
        }

        $em = $this->getDoctrine()->getManager();

        $settingsMain = $em->getRepository('AppBundle:Settings')->findOneBy(['toId'=>(int)$objectId, 'toClassName'=>$tyes[$objectType]]);

        $settingsParent = $em->getRepository('AppBundle:Settings')->findBy(['fromId'=>(int)$objectId, 'fromClassName'=>$tyes[$objectType]]);

        $newSettingMain = clone $settingsMain;
        $newSettingMain->setToClassName(null);
        $newSettingMain->setToId(null);
        $newSettingMain->setPosition($settingsMain->getPosition()+1);

        $newSettingMain = $this->get('app.document.settings')->createDocument($newSettingMain);

       foreach ($settingsParent as $key=>$settings){

           $newSetting = clone $settings;
           $newSetting->setFromId($newSettingMain->getToId());
           $newSetting->setFromClassName($newSettingMain->getToClassName());
           $newSetting->setToClassName(null);
           $newSetting->setToId(null);

           $newSetting = $this->get('app.document.settings')->createDocument($newSetting);
       }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Admin",
     *  description="This function is used to get a all Articles.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function postImageAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $data = $request->request->all();

        $image = $request->files->get('file');

        return $image;
        if (!is_null($image)) {

            $object = new File();
            $object->setFile($image);
            $object->setState(true);
            $object->uploadFile();

            $em->persist($object);
            $em->flush();
        }



//        $request->get()
//        dump()
        return $object->getFileOriginalName();
    }

    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Admin",
     *  description="This function is used to get a all Articles.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getGalleryAction(Request $request){

        return true;
    }
}