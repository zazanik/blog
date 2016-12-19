<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PageController extends Controller
{
    /**
     * @Route("/", name="blog")
     * @Method({"GET"})
     * @Template()
     */
    public function blogAction()
    {
        $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findAll();
        return array('posts' => $posts);
    }

    /**
     * @Route("/posts/{id}", name="single_post")
     * @Method({"GET"})
     * @Template()
     */
    public function singlePostAction($id)
    {
        $post = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->find($id);
        return array('post' => $post);
    }

}
