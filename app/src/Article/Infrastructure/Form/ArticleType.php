<?php

namespace App\Article\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType 
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('title', TextType::class, ['attr' => array('placeholder' => 'Create good Title for your article')])
            ->add('content', TextareaType::class, ['attr' => array('placeholder' => 'Write content to your article...')])
            ->add('mainImagePath', FileType::class, ['data_class' => null, 'label' => false,
            'attr' => array('accept' => 'image/jpeg,image/png')])
            ->add('add', SubmitType::class, ['label' => 'Create Article']);
    }
}
