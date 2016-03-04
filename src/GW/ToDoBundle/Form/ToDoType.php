<?php

namespace GW\ToDoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ToDoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class , array(
              'label' => 'Titre'
            ))
            ->add('expiration', DateType::class, array(
              'label' => 'expire le :'
            ))
            ->add('content', TextareaType::class , array(
              'label' => false
            ))
            ->add('project', EntityType::class, array(
              'label' => 'Projet',
              'class' => 'GWToDoBundle:Project',
              'choice_label' => 'title',
              'multiple' => false,
              'expanded' => false,
            ))
            ->add('Sauvegarder', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GW\ToDoBundle\Entity\ToDo'
        ));
    }
}
