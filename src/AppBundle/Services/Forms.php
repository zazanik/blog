<?php
namespace AppBundle\Services;

use AppBundle\Entity\Post;
use AppBundle\Entity\Author;
use AppBundle\Services\FileUploader;
use AppBundle\Form\AuthorType;
use AppBundle\Form\PostType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\RouterInterface;


class Forms
{
    protected $formFactory;
    protected $doctrine;
    protected $router;
    protected $upload;

    public function __construct(FormFactoryInterface $formFactory,
                                RegistryInterface $doctrine,
                                RouterInterface $router,
                                FileUploader $upload)
    {
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->upload = $upload;

    }



    public function createPostForm(Request $request, Post $post = null)
    {
        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $post = $form->getData();

            $file = $post->getImage();
            $fileName = $this->upload->upload($file);

            $post->setImage($fileName);


            $em->persist($post);
            $em->flush();

            return $this->router->generate('posts_list');
        }
        return $form;
    }

    /**
     * Our new getAllPosts() method
     *
     * 1. Create & pass query to paginate method
     * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
     * 3. Return that object to the controller
     *
     * @param integer $currentPage The current page (passed from controller)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getAllPosts($currentPage = 1)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.created', 'DESC')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    /**
     * Paginator Helper
     *
     * Pass through a query object, current page & limit
     * the offset is calculated from the page and limit
     * returns an `Paginator` instance, which you can call the following on:
     *
     *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
     *     $paginator->count() # Count of ALL posts (ie: `20` posts)
     *     $paginator->getIterator() # ArrayIterator
     *
     * @param Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer            $page  Current page (defaults to 1)
     * @param integer            $limit The total number per page (defaults to 5)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

}