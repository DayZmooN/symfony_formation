<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CategoryController extends AbstractController
{

    #[Route('/category', name: 'category.index')]
    public function index(EntityManagerInterface $em): Response
    {
        /**
     * Affiche la liste de toutes les catégories.
     *
     * Cette méthode utilise le EntityManager pour récupérer toutes les
     * catégories de la base de données via le repository Category.
     * Elle renvoie ensuite la vue correspondante avec les données
     * nécessaires pour l'affichage.
     *
     * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
     * @return Response La réponse HTTP contenant la vue à afficher.
     */
        // Récupération de toutes les catégories avec le repository en utilisant la méthode findAll()
        $datas = $em->getRepository(Category::class)->findAll();

        // Retourne à la vue du template avec render
        return $this->render('category/index.html.twig', [
            // Envoie des données à la vue
            'datas' => $datas
        ]);
    }


    #[Route('/category/create', name: 'category.create')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        /**
         * Affiche le formulaire pour créer une nouvelle catégorie.
         *
         * Cette méthode crée un formulaire basé sur CategoryType,
         * gère la soumission et la validation des données. Si le formulaire
         * est valide, elle enregistre la nouvelle catégorie dans la base
         * de données et redirige vers la liste des catégories.
         *
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @param Request $request La requête HTTP contenant les données du formulaire.
         * @return Response La réponse HTTP contenant la vue du formulaire ou redirection.
         */

        // Création du formulaire de CategoryType
        $form = $this->createForm(CategoryType::class);
        // Récupération des données de la requête avec handleRequest
        $formData = $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($formData->isSubmitted() && $formData->isValid()) {
            // On prépare l'entité pour être sauvegardée
            $em->persist($formData->getData());
            // On envoie les données en BDD
            $em->flush();
            // Création d'un message de succès en session
            $this->addFlash('success', 'category created');
            // Redirection vers la route category.index
            return $this->redirectToRoute('category.index');
        }

        // Retourne la vue pour afficher le formulaire
        return $this->render('category/new.html.twig', [
            // Envoie la variable form pour afficher le formulaire
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'category.show')]
    public function show(Category $category): Response
    {
        /**
         * Affiche les détails d'une catégorie spécifique.
         *
         * Cette méthode récupère la catégorie par son ID,
         * puis renvoie la vue correspondante pour afficher
         * les informations de la catégorie.
         *
         * @param Category $category L'objet catégorie récupéré par l'ID.
         * @return Response La réponse HTTP contenant la vue des détails de la catégorie.
         */

        // Retourne la vue pour afficher les détails de la catégorie
        return $this->render('category/show.html.twig', [
            'category' => $category, // Envoie la catégorie au template
        ]);
    }

    #[Route('/category/{id}/remove', name: 'category.remove')]
    public function remove(EntityManagerInterface $em, Category $category): Response
    {
        /**
         * Supprime une catégorie de la base de données.
         *
         * Cette méthode supprime la catégorie spécifiée,
         * enregistre les changements en base de données,
         * et redirige vers la liste des catégories avec un message de succès.
         *
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @param Category $category L'objet catégorie à supprimer.
         * @return Response La réponse HTTP redirigeant vers la liste des catégories.
         */

        // Supprime la catégorie spécifiée de la base de données
        $em->remove($category);
        // Applique les changements en base de données
        $em->flush();
        // Création d'un message de succès en session pour indiquer que la catégorie a été supprimée
        $this->addFlash('success', 'category removed');
        // Redirection vers la route category.index
        return $this->redirectToRoute('category.index');
    }

    #[Route('/category/{id}/edit', name: 'category.edit')]
    public function edit(EntityManagerInterface $em, Category $category, Request $request): Response
    {
        /**
         * Affiche le formulaire pour éditer une catégorie existante.
         *
         * Cette méthode crée un formulaire pré-rempli avec les données
         * de la catégorie existante. Si le formulaire est soumis et valide,
         * elle enregistre les modifications et redirige vers la liste des catégories.
         *
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @param Category $category L'objet catégorie à éditer.
         * @param Request $request La requête HTTP contenant les données du formulaire.
         * @return Response La réponse HTTP contenant la vue du formulaire ou redirection.
         */

        // Création du formulaire pour éditer la catégorie existante
        $form = $this->createForm(CategoryType::class, $category);
        // Récupération des données de la requête avec handleRequest
        $formData = $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($request->isMethod('POST') && $formData->isSubmitted() && $formData->isValid()) {
            try {
                // Applique les modifications à la base de données
                $em->flush();
                // Création d'un message de succès en session pour indiquer que la catégorie a été mise à jour
                $this->addFlash('success', 'category updated');
                // Redirection vers la route category.index
                return $this->redirectToRoute('category.index');
            } catch (\Exception $e) {
                // En cas d'erreur, ajoute un message d'erreur en session
                $this->addFlash('error', $e->getMessage());
            }
        }

        // Retourne la vue pour afficher le formulaire d'édition de catégorie
        return $this->render('category/edit.html.twig', [
            'form' => $form, // Envoie le formulaire au template
            'category' => $category, // Envoie la catégorie au template
        ]);
    }

}
