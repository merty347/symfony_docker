<?php

namespace App\Article\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType 
{
    //TODO!!!
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formBuilder = $this->createFormBuilder($article); 
            $formBuilder
                ->add('title', TextType::class)
                ->add('content', TextType::class)
                ->add('author', TextType::class)
                ->add('date', DateType::class)
                ->add('imagePath', TextType::class)
                ->add('add', SubmitType::class, ['label' => 'Create Article'])
                ->getForm();
    }
}
