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
     * This action generate pages by menu slug
     *
     * @Route("/page/{slug}", name="singlePage")
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function pageAction($slug)
    {
        // get entity manager
        $em = $this->getDoctrine()->getManager();
        // get data
        $data = $em->getRepository('AppBundle:Menu')->findOneBySlug($slug);

        if(!$data)
        {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }

        return $this->render("@App/Default/page.html.twig", array('data' => $data) );

    }
}
