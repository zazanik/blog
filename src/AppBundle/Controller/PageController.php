<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class PageController
 * @package AppBundle\Controller
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="blog")
     * @Method({"GET"})
     * @Template()
     */
    public function blogAction()
    {

    }

    /**
     * @Route("/posts/{id}", name="single_post")
     * @Method({"GET"})
     * @Template()
     */
    public function singlePostAction($id)
    {
        
    }
}