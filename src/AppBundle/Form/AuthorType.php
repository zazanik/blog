<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'First Name'
                    )
                )
            )
            ->add('lastName', TextType::class,
                array(
                    'label' => false,
                    'attr'  => array(
                        'placeholder'   => 'Last Name'
                    )
                )
            )
            ->add('gender', ChoiceType::class,
                array(
                    'choices'   => array('Male' => 1, 'Female' => 0),
                    'required'  => false,
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
            'data_class' => 'AppBundle\Entity\Author'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_author';
    }


}
