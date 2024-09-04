<?php
// src/Form/LivreType.php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => '* Titre de votre livre, manga, dvd ou jeux :',
                'attr' => ['class' => 'form-control']
            ])
            ->add('imageUrl', TextType::class, [
                'label' => '* URL de l’image :',
                'required' => false, // Rendre ce champ non obligatoire
                'attr' => ['class' => 'form-control']
            ])
            ->add('categorie', ChoiceType::class, [
                'label' => '* Catégorie :',
                'choices' => [
                    'Roman' => 'Roman',
                    'Film' => 'Film',
                    'Music' => 'Music',
                    'Manga' => 'Manga',
                    'Jeux' => 'Jeux',
                    'BD' => 'BD'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('tome', TextType::class, [
                'label' => 'Tome :',
                'required' => false, // Rendre ce champ non obligatoire
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', TextType::class, [
                'label' => 'Prix :',
                'required' => false, // Rendre ce champ non obligatoire
                'attr' => ['class' => 'form-control']
            ])
            ->add('auteur', TextType::class, [
                'label' => 'Auteur :',
                'required' => false, // Rendre ce champ non obligatoire
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
