<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AsphaltingTypes;
use AppBundle\Entity\Settings;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage", options={"sitemap" = true})
     * @Cache(expires="tomorrow", public=true)
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'homepage']);

        return $this->render('default/index.html.twig', ['data'=>$data]);
    }


    /**
     * @Route("/dorozhnye-stroitelstvo", name="asphalting_list", options={"sitemap" = true})
     * @Template()
     */
    public function asphaltingAction(Request $request){

        $em = $this->getDoctrine()->getManager();


        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'dorozhnye-stroitelstvo']);

        $asphalting = $em->getRepository('AppBundle:AsphaltingTypes')->findForList();


        return ['data'=>$data, 'asphalting'=>$asphalting];

    }

    /**
     * @Route("/arenda-spetstekhniki", name="rent_equipments" , options={"sitemap" = true})
     * @Template()
     */
    public function equipmentsAction(Request $request){

        $em = $this->getDoctrine()->getManager();


        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'arenda-spetstekhniki']);

        $equipment = $em->getRepository('AppBundle:EquipmentTypes')->findForList();

//dump($equipment); exit;
        return ['data'=>$data, 'equipments'=>$equipment];

    }

    /**
     * @Route("/o-asphalt-kiev", name="about_us" , options={"sitemap" = true})
     * @Cache(expires="tomorrow", public=true)
     * @Template()
     */
    public function aboutUsAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'o-asphalt-kiev']);



        return ['data'=>$data];

    }

    /**
     * @Route("/contact-us", name="contact-us")
     * @Cache(expires="tomorrow", public=true)
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'contact-us']);

        $form = $this->createForm(ContactType::class);

        if(!$data){
            return $this->redirectToRoute('page', ['slug'=>'about-us']);
        }

        return ['data'=>$data,'form'=>$form->createView()];
    }


    /**
     * @Route("/pricing", name="priceing", options={"sitemap" = true})
     * @Template()
     */
    public function priceingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'pricing']);

        $asphaltPrice = $em->getRepository('AppBundle:AsphaltingTypes')->findPricing();

        $equipmentPrice = $em->getRepository('AppBundle:EquipmentTypes')->findPricing();

        if(!$data){
            return $this->redirectToRoute('page', ['slug'=>'about-us']);
        }

        return ['data'=>$data, 'asphaltPrice'=>$asphaltPrice, 'equipmentPrice'=>$equipmentPrice];
    }

    /**
     * @Route("/{slug}", name="asphalt_type")
     * @Template()
     */
    public function asphaltTypeAction(Request $request, $slug){

        $em = $this->getDoctrine()->getManager();

        $data =  $em->getRepository('AppBundle:AsphaltingTypes')->findSingleType($slug);

        if(!$data){
            $data =  $em->getRepository('AppBundle:EquipmentTypes')->findSingleType($slug);
        }

        $sugested = [];
        if($data[0]->getIsSingle() == true) {

            if($data[0] instanceof AsphaltingTypes) {

                $sugested['otherTypes'] = $em->getRepository('AppBundle:AsphaltingTypes')->findOther($slug);

                $sugested['needed'] = $em->getRepository('AppBundle:Equipments')->findAllForParent();
            }else{
                $sugested['otherTypes'] = $em->getRepository('AppBundle:EquipmentTypes')->findOther($slug);

                $sugested['needed'] = $em->getRepository('AppBundle:AsphaltingTypes')->findAllForParent();
            }

        }


        return ['data'=>$data[0], 'sugested'=>$sugested];

    }

    /**
     * @Route("/{slugType}/{slugAsphalt}", name="asphalt_single")
     * @Template()
     */
    public function asphaltSingleAction(Request $request, $slugType, $slugAsphalt){

        $em = $this->getDoctrine()->getManager();

        $sugested = [];

        $data = $em->getRepository('AppBundle:Asphalting')->findSingle($slugAsphalt);

        if(!$data) {

            $data = $em->getRepository('AppBundle:Equipments')->findSingle($slugAsphalt);

            $sugested['parent'] = $em->getRepository('AppBundle:EquipmentTypes')->findSugested($slugType, $slugAsphalt)[0];

            $sugested['otherTypes'] = $em->getRepository('AppBundle:EquipmentTypes')->findOther($slugType);

            $sugested['needed'] = $em->getRepository('AppBundle:AsphaltingTypes')->findAllForParent();

        }else{

            $sugested['parent'] = $em->getRepository('AppBundle:AsphaltingTypes')->findSugested($slugType, $slugAsphalt)[0];

            $sugested['otherTypes'] = $em->getRepository('AppBundle:AsphaltingTypes')->findOther($slugType);

            $sugested['needed'] = $em->getRepository('AppBundle:Equipments')->findAllForParent();
        }

        return ['data'=>$data, 'sugested'=>$sugested];

    }

    /**
     * @Route("/projects-main", name="projects_main")
     * @Cache(expires="tomorrow", public=true)
     * @Template()
     */
    public function projectsMainAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:Projects')->findAll();

        return ['projects'=>$projects];

    }

    /**
     * @Route("/{slug}", name="page")
     * @Cache(expires="tomorrow", public=true)
     * @Template()
     */
    public function pageAction(Request $request, $slug){

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>$slug]);

        

        return $this->render('AppBundle:Main:' . $data->getSlug().'.html.twig', ['data'=>$data]);

    }

//    /**
//     * @Route("/about-main", name="about-main")
//     * @Cache(expires="tomorrow", public=true)
//     * @Template()
//     */
//    public function aboutMainAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//
////        $data = $em->getRepository('AppBundle:Pages')->findOneBy(['slug'=>'homepage']);
//
////        $settings = $em->getRepository('AppBundle:Settings')->findSettingsPage($data->getClassName(), $data->getId());
//
//        return [];
//    }










    /**
     * TODO : Old
     */

    /**
     * @Route("/product", name="products")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function productsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->findAll();

        return ['products'=>$products];
    }

    /**
     * @Route("/product/{slug}", name="product_single")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function productSingleAction(Request $request, $slug)
    {

        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AppBundle:Products')->findOneBySlug($slug);

        if(!$product){
            return $this->redirectToRoute('products');
        }

        $settings = $em->getRepository('AppBundle:Settings')->findSettingsPage($product->getClassName(), $product->getId());


        return ['product'=>$product, 'settings'=>$settings];
    }

    /**
     * @Route("/projects", name="projects")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function projectsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AppBundle:Projects')->findAll();

        return ['projects'=>$projects];
    }

    /**
     * @Route("/projects/{slug}", name="project-single")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function projectSingleAction(Request $request, $slug)
    {

        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('AppBundle:Projects')->findOneBy(['slug'=>$slug]);

        $settings = $this->getSettings($project->getClassName(), $project->getId());

        return ['product'=>$project, 'settings'=>$settings];
    }

    /**
     * @Route("/services", name="services")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function servicesAction(Request $request)
    {

//        $em = $this->getDoctrine()->getManager();
//
//        $products = $em->getRepository('AppBundle:Products')->findQuick();

        return ['products'=>'aa'];
    }

    /**
     * @Route("/remove-image/{filename}/{object}", name="remove_image")
     * @Security("has_role('ROLE_USER')")
     * @param $filename
     * @param $object
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function removeImageAction($filename, $object)
    {
        try{
            // get entity manager
            $em = $this->getDoctrine()->getManager();

            // get object by className
            $object = $em->getRepository($object)->findOneBy(array('fileName' => $filename));


            // get origin file path
            $filePath = $object->getAbsolutePath() . $object->getFileName();

            // get doctrine
            $em = $this->getDoctrine()->getManager();

            // check file and remove
            if (file_exists($filePath) && is_file($filePath)){
                unlink($filePath);
            }

            $object->setFileName(null);
            $object->setFileOriginalName(null);

            $em->persist($object);
            $em->flush();

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        catch(\Exception $e){
            throw $e;
        }

    }

    /**
     * @Route("/test/info", name="test-single")
     * @Cache(expires="tomorrow", public=true)
     */
    public function getTextAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_encode(array(
            array(
                'id' => 111,
                'title' => "Event1",
                'start' => "sssss-10",
                'url' => "http://yahoo.com/"
            ),
        ));
        $headers = array(
            'Content-Type' => 'application/json'
        );

        $response = new Response($jsonData, 200, $headers);
        return $response;

    }

    /**
     * @Route("/{slug}", name="service-single")
     * @Template()
     * @Cache(expires="tomorrow", public=true)
     */
    public function serviceSingelAction(Request $request, $slug)
    {

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:ProductServices')->findSingle($slug);

        return ['data'=>$data];
    }






    public function getSettings($className, $id){

        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AppBundle:Settings')->findSettingsPage($className, $id);


        return $settings;
    }


}
