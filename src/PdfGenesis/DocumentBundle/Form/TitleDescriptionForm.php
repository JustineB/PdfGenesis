<?php

namespace PdfGenesis\DocumentBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TitleDescriptionForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,array(
                'label' => 'Title',
                'attr' => array('class' => 'form-control default-input',)
            ))
            ->add('description', TextareaType::class,array(
                'label' => 'Description',
                'attr' => array('class' => 'form-control default-input')
            ));
    }
}