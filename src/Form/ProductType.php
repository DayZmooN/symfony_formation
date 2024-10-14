<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * Construit le formulaire Product avec les champs nécessaires.
     *
     * @param FormBuilderInterface $builder L'interface pour construire le formulaire.
     * @param array $options Options pour configurer le formulaire.
     * @return void Cette méthode ne retourne rien.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajoute un champ pour le nom du produit
            ->add('name', TextType::class, [
                'label' => 'Nom du produit', // Étiquette du champ
            ])
            // Ajoute un champ pour la description du produit
            ->add('description', TextType::class, [
                'label' => 'Description du produit', // Étiquette du champ
            ])
            // Ajoute un champ pour le prix du produit
            ->add('price', TextType::class, [
                'label' => 'Prix du produit', // Étiquette du champ
                'attr' => [
                    'placeholder' => 'Entrez le prix', // Placeholder pour le champ
                ],
            ])
            // Ajoute un champ pour sélectionner la catégorie du produit
            ->add('category', EntityType::class, [
                'class' => Category::class, // Classe de l'entité à laquelle se rattache le champ
                'choice_label' => 'name', // Champ de l'entité qui sera affiché dans le sélecteur
            ])
            // Ajoute un bouton de soumission
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer', // Étiquette du bouton
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
            'data_class' => Product::class, // Associe le formulaire à la classe Product
        ]);
    }
}
