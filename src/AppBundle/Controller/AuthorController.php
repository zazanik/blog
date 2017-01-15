<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Author controller.
 *
 */
class AuthorController extends Controller
{
    /**
     * Lists all author entities.
     *
     * @Route("/authors", name="author_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $authors = $em->getRepository('AppBundle:Author')->findAll();

        return array(
            'authors' => $authors,
        );
    }

    /**
     * Creates a new author entity.
     *
     * @Route("/authors/create", name="author_create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $author = new Author();
        $form = $this->createForm('AppBundle\Form\AuthorType', $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush($author);

            return $this->redirectToRoute('single_author', array('id' => $author->getId()));
        }

        return array(
            'author' => $author,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a author entity.
     *
     * @Route("/authors/{id}", name="single_author")
     * @Method("GET")
     * @Template()
     */
    public function viewAction(Author $id)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:Author");
        $author = $em->find($id);

        $posts = $this->getDoctrine()->getRepository(Post::class)->sortByDate();

        dump($author);

        return array(
            'author' => $author,
            'posts' => $posts
        );
    }

    /**
     * Displays a form to edit an existing author entity.
     *
     * @Route("/author/edit/{id}", name="author_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Author $author)
    {
        $editForm = $this->createForm('AppBundle\Form\AuthorType', $author);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author_edit', array('id' => $author->getId()));
        }

        return array(
            'author' => $author,
            'edit_form' => $editForm->createView(),
        );
    }

}
