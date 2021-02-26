<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => ['user_create'],
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'groups' => ['user_create'],
                        'max' => 255,
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                    ]),
                ],
                'first_options'  => ['label' => 'Password'],
                'invalid_message' => 'The password fields must match.',
                'mapped' => false,
                'second_options' => ['label' => 'Repeat Password'],
                'type' => PasswordType::class,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => ['class' => 'my-5'],
                'constraints' => [
                    new IsTrue([
                        'groups' => ['user_create'],
                        'message' => 'You should agree to our privacy policy and terms of service.',
                    ]),
                ],
                'label' => 'I consent to the privacy policy and terms of service.',
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'is-link is-fullwidth'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['novalidate' => 'novalidate'],
            'data_class' => User::class,
            'validation_groups' => ['Default', 'user_create'],
        ]);
    }
}
