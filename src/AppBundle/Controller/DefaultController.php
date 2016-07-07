<?php

namespace AppBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($this->getUser() == ''){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     *
     * @Template()
     *
     * @param $slug
     * @return array
     */
    public function mainAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = $em->getRepository('AppBundle:Menu')->findOneBySlug($slug);

        return array('menu' => $menu);
    }

    /**
     *
     * @Template()
     * @param $slug
     * @return array
     */
    public function aboutAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = $em->getRepository('AppBundle:Menu')->findOneBySlug($slug);

        return array('menu' => $menu);
    }

    /**
     * @Template()
     * @param $slug
     * @return array
     */
    public function portfolioAction($slug)
    {
        $data = $this->getMenuData($slug);
        return array('menu' => $data);

    }

    /**
     *
     * @Template()
     * @param $slug
     * @return array
     */
    public function servicesAction($slug)
    {
        $data = $this->getMenuData($slug);
        return array('menu' => $data);
    }

    /**
     *
     * @Template()
     * @param $slug
     * @return array
     */
    public function pricingAction($slug){
        $data = $this->getMenuData($slug);
        return array('menu' => $data);
    }

    private function getMenuData($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = $em->getRepository('AppBundle:Menu')->findOneBySlug($slug);

        return $menu;
    }


    /**
     * @Template()
     * @param $slug
     * @return array
     */
    public function contactAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $menu = $em->getRepository('AppBundle:Menu')->findOneBySlug($slug);

        return $menu;
    }
}
