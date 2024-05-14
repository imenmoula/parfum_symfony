<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('firstname', TextType::class, 
           ['label' => ' votre Prénom',
           'attr' => [
           'placeholder' => 'merci Entrer votre Prénom',
           ]
        ])    
        ->add('lastname',TextType::class, 
        ['label' => ' votre Nom',
        'attr' => [
        'placeholder' => 'merci Entrer votre Nom',
        ]])
            ->add('telephone',TextType::class, 
            ['label' => ' votre Téléphone',
            'attr' => [
            'placeholder' => 'merci Entrer votre Téléphone',
            ]])
            ->add('adresse',TextType::class, 
            ['label' => ' votre Adresse',
            'attr' => [
            'placeholder' => 'merci Entrer votre Adresse',
            ]])
            ->add('email',EmailType::class,[
            'label' => ' votre Email',
            'attr' => [
            'placeholder' => 'merci Entrer votre Email',
            ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'svp entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'svp entrer un mot de passe {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
        //     ->add('submit', SubmitType::class, 
        //     ['label' => 'S\'inscrire'])

        // ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    
}
