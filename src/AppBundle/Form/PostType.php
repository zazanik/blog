<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Fixtures\AuthorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                            'class'       => 'form-control'
                        )
                )
            )
            ->add('content', TextareaType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Content',
                        'class'         => 'form-control'
                    )
                )
            )
            ->add('description', TextareaType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Description',
                        'class'         => 'form-control'
                    )
                )
            )
            ->add('thumb', TextType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Image',
                        'class'         => 'form-control'
                    )
                )
            )
            ->add('author', CollectionType::class,
                array(
                    'entry_type'   => TextType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'prototype_data' => 'New Tag Placeholder',
                )
            );
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
