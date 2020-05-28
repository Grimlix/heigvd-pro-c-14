<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use App\Validator\Tocken;


class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Code de participation'
                ),
                'label' => false,
                'constraints' => [
                        new Length(['min' => 5, 'max' => 12 ]),
                        new Tocken(),
                    ],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}