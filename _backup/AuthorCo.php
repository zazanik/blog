<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;

use AppBundle\Repository\PostRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AuthorController extends Controller
{
    /**
     * @Route("/authors", name="author_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:Author");
        $authors = $em->findAll();
        return array('authors' => $authors);
    }

    /**
     * @param int $id
     * @return array
     *
     * @Route("/author/{id}", name="single_author")
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:Author");
        $author = $em->find($id);

        $posts = $this->getDoctrine()->getRepository(Post::class)->sortByDate();

        return array(
            'author' => $author,
            'posts' => $posts
        );
    }
    
}
