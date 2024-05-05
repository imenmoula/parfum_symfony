<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            /*->add('nom')
            ->add('description')
            ->add('image')
            >add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
            ->add('date_update', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('sexe')

        ;*/
        $builder
        ->add('nom')
        ->add('description')
        ->add('image', FileType::class, [ // Correction ici
            'label' => 'Image',
            'required' => false,
        ])
        ->add('date_creation', null, [
            'widget' => 'single_text',
        ])
        ->add('date_update', null, [
            'widget' => 'single_text',
        ])
       
        ->add('status')
        ->add('sexe');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
