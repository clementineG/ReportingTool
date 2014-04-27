<?php

namespace ProjectManager\ParameterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PossibleValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectManager\ParameterBundle\Entity\PossibleValue'
        ));
    }

    public function getName()
    {
        return 'projectmanager_parameterbundle_possiblevaluetype';
    }
}
