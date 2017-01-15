<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param Request $request
     *
     * @Route("/posts/create", name="post_create")
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $result = $this->get('app.form_manager')
            ->createPostForm($request);
        if (!$result instanceof Form) {
            return $this->redirect($result);
        }
        return [
            'postType' => $result->createView()
        ];
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
        dump($post);
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
