<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * Construit le formulaire Category avec les champs nécessaires.
     *
     * @param FormBuilderInterface $builder L'interface pour construire le formulaire.
     * @param array $options Options pour configurer le formulaire.
     * @return void Cette méthode ne retourne rien.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajoute un champ pour le nom de la catégorie
            ->add('name', TextType::class, [
                'label' => 'Nom', // Étiquette du champ
                'empty_data' => "", // Valeur par défaut si le champ est vide
            ])
            // Ajoute un bouton de soumission
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer', // Étiquette du bouton
            ]);
    }

    /**
     * Configure les options pour le formulaire.
     *
     * @param OptionsResolver $resolver Un objet qui permet de définir les options du formulaire.
     * @return void Cette méthode ne retourne rien.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Définit les options par défaut pour le formulaire
        $resolver->setDefaults([
            'data_class' => Category::class, // Associe le formulaire à la classe Category
        ]);
    }
}
