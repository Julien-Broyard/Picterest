<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PinFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class, [
                'attr' => ['class' => 'file-input'],
                'constraints' => [
                    new Image(
                        [
                            'groups' => ['pin_creation_update'],
                            'maxSize' => '2M',
                            'mimeTypes' => ['image/jpeg', 'image/png'],
                            'mimeTypesMessage' => 'Only .jpeg and .png are accepted.',
                        ]
                    ),
                ],
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
            'data_class' => Pin::class,
            'validation_groups' => ['Default', 'pin_creation_update']
        ]);
    }
}
