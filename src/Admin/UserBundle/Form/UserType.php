<?php

namespace Admin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('acronym','text')
            ->add('firstname','text')
            ->add('lastname','text')
            ->add('email','text')
            ->add('roles', 'entity', array(
                    'class'    => 'AdminRoleBundle:Role',
                    'property' => 'name',
                    'expanded' => true,
                    'multiple' => true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'admin_userbundle_usertype';
    }
}
