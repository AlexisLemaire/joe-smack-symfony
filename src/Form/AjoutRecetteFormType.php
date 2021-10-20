<?php

namespace App\Form;

use App\Entity\Recettes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutRecetteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'entree' => 'entree',
                    'plat' => 'plat',
                    'patisserie' => 'patisserie'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', IntegerType::class, [
                'required' => true,
                'label' => 'Prix',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prepDuration', IntegerType::class, [
                'required' => true,
                'label' => 'Temps de préparation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbPersonnes', IntegerType::class, [
                'required' => true,
                'label' => 'Nombre de personnes',
                'attr' => ['class' => 'form-control']
            ])
            ->add('ingredients', TextType::class, [
                'label' => "Ingrédients (Séparer par des virgules)",
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('img', FileType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Image',
                'attr' => ['class' => 'form-control']
            ])
            ->add('text', TextType::class, [
                'required' => true,
                'label' => 'Recette',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
