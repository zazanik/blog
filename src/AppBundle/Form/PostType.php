<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Fixtures\AuthorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                array(
                    'label' => false,
                    'attr' =>
                        array(
                            'placeholder' => 'Title',

                        )
                )
            )
            ->add('content', TextareaType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Content',
                    )
                )
            )
            ->add('description', TextareaType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Description',
                    )
                )
            )
            ->add('author', EntityType::class,
                array(
                    'class' => 'AppBundle:Author',
                    'choice_label' => 'lastName',
                )
            )
            ->add('image', FileType::class,
                array(
                    'label' => 'image (image file)',
                    'data_class' => 'Symfony\Component\HttpFoundation\File\File'
                )
            )
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
            'attr'       => array(
                'novalidate'=>'novalidate'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }
}
