<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 * @package AppBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @return array
     *
     * @Route("/", name="posts_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:Post");
        $posts = $em->findAll();
        return array('posts' => $posts);
    }

    /**
     * Creates a new post entity.
     *
    //     * @param Request $request
    //     * @return array
     *
     * @Route("/posts/create", name="post_create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('single_post', array('id' => $post->getId()));
        }

        return array(
            'post'      => $post,
            'form'      => $form->createView(),
        );
    }

    /**
     * @param int $id
     * @return array
     *
     * @Route("/posts/{id}", name="single_post")
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("AppBundle:Post")->find($id);
        return array('post' => $post);
    }

    /**
     * 
     * @Route("/posts/edit/{id}", name="edit_post")
     * @Template()
     */
    public function editAction(Request $request, Post $post)
    {
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edit_post', array('id' => $post->getId()));
        }

        return array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        );


    }

}
