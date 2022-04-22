<?php

namespace App\User\Infrastructure\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Form\FormTypeInterface;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class, ['attr' => array('placeholder' => '')])
        ->add('first_name', TextType::class, ['attr' => array('placeholder' => 'First Name')])
        ->add('last_name', TextType::class, ['attr' => array('placeholder' => 'Last Name')])
        ->add('description', TextType::class, ['attr' => array('placeholder' => 'Write something about yourself')]);    
    }
}