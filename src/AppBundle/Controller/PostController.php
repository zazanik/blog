<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @return array
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
     * @param int $id
     * @return array
     * @Route("/posts/{id}", name="single_post")
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:Post");
        $post = $em->find($id);
        return array("post" => $post);
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/posts/create", name="post_create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\CreatePostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('single_post', array('id' => $post->getId()));
        }

        return array(
            'post' => $post,
            'form' => $form->createView(),
        );
    }

    /**
     * 
     * @Route("/posts/edit/{id}", name="edit_post")
     * @Template()
     */
    public function editAction(Request $request, Post $post)
    {
//        $em = $this->getDoctrine()->getRepository("AppBundle:Post");
//        $post = $em->find($id);
//        return array("post" => $post);



//        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);
        dump($editForm);

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

//    /**
//     * Creates a form to delete a post entity.
//     *
//     * @param Post $post The post entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Post $post)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('', array('id' => $post->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//            ;
//    }

}
