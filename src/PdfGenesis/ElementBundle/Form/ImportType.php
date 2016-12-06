<?php


namespace PdfGenesis\ElementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('path', \Symfony\Component\Form\Extension\Core\Type\FileType::class,array(
                'attr' => array('accept' => "image/x-png,image/gif,image/jpeg")
           ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(array(
          'data_class' => 'PdfGenesis\ElementBundle\Entity\File'
       ));
    }

}