<?php

declare(strict_types=1);

/*
 * This file is part of the Picterest source code.
 *
 * (c) Julien Broyard <broyard.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => ['change_password'],
                        'message' => 'The password is required.',
                    ]),
                    new Length([
                        'groups' => ['change_password'],
                        'max' => 255,
                        'maxMessage' => 'Your password should not exceed {{ limit }} characters.',
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters.',
                    ]),
                ],
                'first_options' => ['label' => 'Password'],
                'invalid_message' => 'The password fields must match.',
                'mapped' => false,
                'second_options' => ['label' => 'Repeat Password'],
                'type' => PasswordType::class,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'is-link is-fullwidth'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validation_groups' => ['Default', 'change_password'],
        ]);
    }
}
