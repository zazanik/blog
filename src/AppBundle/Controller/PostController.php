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

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PostController
 * @package AppBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="posts_list")
     * @Template()
     *
     * @return array
     */
    public function listAction(Request $request)
    {
        $thisPage = $request->query->get('page');
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->getAllPosts($thisPage);
        $pagesParameters = $this->get('app.pgManager')->paginate($thisPage, $posts);
        return array('posts' => $posts, 'maxPages' => $pagesParameters[0], 'thisPage' => $pagesParameters[1]);
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
        dump($post);

        $post->setImage(
            new File($this->getParameter('images_directory').'/'.$post->getImage())
        );
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('single_post', array('id' => $post->getId()));
        }
        return array(
            'post' => $post,
            'postType' => $editForm->createView(),
        );
    }
}
