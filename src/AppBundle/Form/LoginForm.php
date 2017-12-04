<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username')
            ->add('_password', PasswordType::class)
        ;
    }

    public function getBlockPrefix()
    {
        // When building a login form that will be used with Symfony's native form_login system,
        // We have to override getBlockPrefix() and make it return an empty string.
        // This will put the POST data in the proper place so the form_login system can find it.
        return '';
    }
}
