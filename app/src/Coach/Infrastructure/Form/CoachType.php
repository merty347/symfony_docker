<?php

namespace App\Coach\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoachType extends AbstractType 
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('license', TextType::class, ['attr' => array('placeholder' => 'Number of your license')])
            ->add('club', TextType::class, ['attr' => array('placeholder' => 'What club are you a coach at?')])
            ->add('ask', SubmitType::class, ['label' => 'Ask about veryfication']);
    }
}
