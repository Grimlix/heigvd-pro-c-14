<?php

namespace App\Form;

use App\Controller\Admin_controller;
use App\Controller\Token_controller;
use App\Entity\Poll;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token', TextType::class,
                ['constraints' => new Assert\Callback([Token_controller::class, 'validate']),
                'attr' =>
                    ['placeholder' => 'Code de participation']])
            ->add('Participer', SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poll::class
        ]);
    }

}