<?php

namespace ProjectManager\ParameterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', 'entity', array(
                    'class'    => 'ProjectManagerParameterBundle:Type',
                    'property' => 'name',
                    'expanded' => false,
                    'multiple' => false))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectManager\ParameterBundle\Entity\Parameter'
        ));
    }

    public function getName()
    {
        return 'projectmanager_parameterbundle_parametertype';
    }
}
