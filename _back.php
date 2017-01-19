<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * @Route("/category/create", name="category_create")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     *
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            return $this->redirectToRoute('posts_list');
        }
        return array(
            'category'  => $category,
            'form'      => $form->createView(),
        );
    }

    /**
     * @Route("/category", name="category_list")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        return array('categories' => $categories);
    }


    /**
     * @Route("/category/edit/{id}", name="category_edit")
     * @Template()
     *
     * @param Request $request
     * @param Category $category
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm(CategoryType::class, $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('category_list');
        }
        return array(
            'category' => $category,
            'form'     => $editForm->createView(),
        );
    }


    /**
     * Deletes a category entity.
     *
     * @Route("/category/delete/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush($category);
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}