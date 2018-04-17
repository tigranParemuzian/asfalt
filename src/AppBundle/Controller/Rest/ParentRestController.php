<?php

namespace AppBundle\Controller\Rest;


use AppBundle\Entity\Asphalting;
use AppBundle\Entity\Equipments;
use AppBundle\Entity\File;
use AppBundle\Entity\Settings;
use AppBundle\Model\MainObjectabeleInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View as RestView;

/**
 * Class ParentRestController
 * @package AppBundle\Controller\Rest
 *
 * @RouteResource("Parent")
 * @Rest\Prefix("/api")
 * @Rest\NamePrefix("rest_")
 */
class ParentRestController extends FOSRestController
{

    private $templates;

    private $header;

    public function __construct()
    {
        $this->templates = [Settings::IS_GALLERY=>'gallery',Settings::IS_TEXT=>'text', Settings::IS_TEXT_AREA=>'long_text',
            Settings::IS_BOOLEAN=>'on_off', Settings::IS_FILE=>'file', Settings::IS_IMAGE=>'image', Settings::IS_VIDEO=>'video',
            Settings::IS_DOCUMENTS_LIST=>'documents_listing'
            ];
        $this->header  = ['Content-Type' => 'application/json'];
    }

    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getAction($objectClass, int $objectId, int $toClassType)
    {
        $em = $this->getDoctrine()->getManager();

        $object = $em->getRepository($objectClass)->find($objectId);

        $result = $object;

        if($object instanceof MainObjectabeleInterface){
            $settings = $this->getSettings($object->getClassName(), $object->getId());
            $result = [];
            $result['data'] = $object;
            $result['settings'] = $settings;
        }

        $view = $this->view($result, Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:" . $this->templates[$toClassType] .".html.twig")
            ->setTemplateVar('element')
        ;
        return $this->handleView($view);

    }

    /**
     * This function used to get single object info for MainObjectabeleInterface parents
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function used to get single object info for MainObjectabeleInterface parents.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View()
     */
    public function getInfoAction(Request $request, $objectClass, int $objectId)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em
            ->createQuery('
            SELECT p FROM '.$objectClass.' p
            WHERE p.id = :id
           '
            )->setParameter('id', $objectId)
        ;

        $object =$query->getArrayResult();

        if(count($object) > 0){
            $object = array_merge($object[0], ['objectClass'=>$objectClass]);
        }

        if($objectClass === 'AppBundle\Entity\File'){

            $object = array_merge($object, ['downloadLink'=>'/uploads/files/' . $object['fileName']]);
        }

        $response = new Response(json_encode($object), Response::HTTP_OK, $this->header);

        $response
            ->setMaxAge(86400)
            ->setSharedMaxAge(86400);
        ;
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * This function used to get Header information
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getSettingsAction(Request $request, $objectClass, $objectId) {

        $em = $this->getDoctrine()->getManager();


        $settings = $em->getRepository('AppBundle:Settings')->findSettingsPageArray($objectClass, $objectId);

        $response = new Response(json_encode($settings), Response::HTTP_OK, $this->header);

        $response
            ->setMaxAge(86400)
            ->setSharedMaxAge(86400);
        ;
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * This function used to get Header information
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getPageAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $object = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>$slug]);

        $result = $object;
        if($object instanceof MainObjectabeleInterface){
            $settings = $this->getSettings($object->getClassName(), $object->getId());
            $result = [];
            $result['data'] = $object;
            $result['settings'] = $settings;
        }

        $view = $this->view($result, Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:" . $slug .".html.twig")
            ->setTemplateVar('element')
        ;


//        $view = RestView::create($result, Codes::HTTP_OK);
//        $view->setFormat("json");
//        $view->setSerializationContext(SerializationContext::create()
//            ->setGroups(array('tag_project', 'tag')));
        $handler = $this->get('fos_rest.view_handler');

        $response = $handler->handle($view)
            ->setMaxAge(86400)
            ->setSharedMaxAge(86400);
        ;
        $response->headers->addCacheControlDirective('must-revalidate', true);


        return $response;

    }




    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getGalleryAction($objectClass, int $objectId)
    {
        $em = $this->getDoctrine()->getManager();

        $object = $em->getRepository($objectClass)->find($objectId);

        $result = $object;
        if($object instanceof MainObjectabeleInterface){
            $settings = $this->getSettings($object->getClassName(), $object->getId());
            $result = [];
            $result['data'] = $object;
            $result['settings'] = $settings;
        }

        $view = $this->view($result, Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:gallery_Item.html.twig")
            ->setTemplateVar('element')
        ;
        return $this->handleView($view);

    }


    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $result = ['asphalt_parent'=>$em->getRepository('AppBundle:AsphaltingTypes')->findAllForParent(),
            'equipment_parent'=>$em->getRepository('AppBundle:EquipmentTypes')->findAllForParent()]
        ;

        $view = $this->view($result, Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:menu.html.twig")
            ->setTemplateVar('element')
        ;
        return $this->handleView($view);

    }


    /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get a all Parent settings.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getTopAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'top-products']);

        $asphaltTop = $em->getRepository('AppBundle:Asphalting')->findBy(['state'=>Asphalting::IS_TOP]);
        $equipment = $em->getRepository('AppBundle:Equipments')->findBy(['state'=>Equipments::IS_TOP]);
        $result = ['top_products'=>array_merge($asphaltTop,$equipment), 'data'=>$data];

        $view = $this->view($result, Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:top.html.twig")
            ->setTemplateVar('element')
        ;
        return $this->handleView($view);

    }



    public function getSettings($className, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AppBundle:Settings')->findSettingsPage($className, $id);


        return $settings;
    }

     /**
     * This function return bag info
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Parent",
     *  description="This function is used to get Left panel.",
     *  statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\View(serializerGroups={"booking_list"})
     */
    public function getLeftAction($objectClass, int $objectId)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $this->getDoctrine()->getManager()
            ->createQuery('
            SELECT p FROM '.$objectClass.' p
            WHERE p.id != :id
            order by p.name ASC'
            )->setParameter('id', $objectId)
        ;

        $object =$query->getResult();

        $view = $this->view(['page'=>'Products','object'=>$object], Response::HTTP_OK)
            ->setTemplate("AppBundle:Parent:left_panel.html.twig")
            ->setTemplateVar('element')
        ;
        return $this->handleView($view);

    }

    /**
     * This function is used to send contact email
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get a all Articles.",
     *  statusCodes={
     *         200="Returned when successful",
     *     } ,
     *     parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of client"},
     *      {"name"="phone", "dataType"="string", "required"=true, "description"="phone of client"},
     *      {"name"="email", "dataType"="email", "required"=true, "description"="email of client"},
     *      {"name"="message", "dataType"="textarea", "required"=true, "description"="client message"}
     *     }
     * )
     * @Rest\View()
     */
    public function postContactAction(Request $request){

        $data = $request->request->get('app_bundle_contact');

        $this->sendEmail($data);

        return $data;

    }

    public function sendEmail($data){




        try{

            $message = \Swift_Message::newInstance()
                ->setSubject("Запрос от {$data['name']}" )
                ->setFrom("{$data['email']}")
                ->setTo("info@asphalt.kiev.ua");
//                ->setReplyTo("servise-center-apple@yandex.ru");

            $message->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    '@App/Main/email_content.html.twig',
                    $data
                ),
                'text/html'
            )

            ;
            $this->get('mailer')->send($message);

        } catch (\Swift_Message $exception){

            $this->addFlash(
                'error',
                "Sorry  {$data['name']} not found."
            );

        }
    }
}