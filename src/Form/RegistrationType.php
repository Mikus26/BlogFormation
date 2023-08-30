<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'attr' => [
                    'placeholder' => 'john@exemple.com'
                ],
                'required' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent matcher',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe:', 'attr' => [
                    'placeholder' => 'S3CR3T'
                ]],
                'second_options' => [
                    'label' => 'Confirmer mot de passe:',
                    'attr' => ['placeholder' => 'S3CR3T']
                ],
                'mapped' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'John',
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Doe',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
