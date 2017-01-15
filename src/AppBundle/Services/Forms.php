<?php
namespace AppBundle\Services;

use AppBundle\Entity\Post;
use AppBundle\Services\FileUploader;
use AppBundle\Form\AuthorType;
use AppBundle\Form\PostType;
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

    public function createPostForm(Request $request, PostType $post = null)
    {
        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $post = $form->getData();

            $file = $post->getImage();
            $fileName = $this->upload->upload($file);

            $post->setImage('/uploads/images/' . $fileName);


            $em->persist($post);
            $em->flush();

            return $this->router->generate('posts_list');
        }
        return $form;
    }
}