<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Parfum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ParfumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('qte_stock')
            ->add('image', FileType::class, [ // Correction ici
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
            ])            ->add('volume')
            ->add('genre')
            ->add('date_creation', null, [
                'widget' => 'single_text',
            ])
            ->add('date_update', null, [
                'widget' => 'single_text',
            ])
            ->add('marque')
            ->add('category', EntityType::class, [
                'class' => category::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parfum::class,
        ]);
    }
}
