<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product.index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        /**
         * Affiche la liste de tous les produits.
         *
         * Cette méthode utilise l'EntityManager pour récupérer tous les
         * produits de la base de données via le repository Product.
         * Elle renvoie ensuite la vue correspondante avec les données
         * nécessaires pour l'affichage.
         *
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @return Response La réponse HTTP contenant la vue à afficher.
         */

        // Récupération de tous les produits avec le repository en utilisant la méthode findAll()
        $datas = $em->getRepository(Product::class)->findAll();

        // Retourne à la vue du template avec render
        return $this->render('product/index.html.twig', [
            // Envoie des données à la vue
            'datas' => $datas,
        ]);
    }

    #[Route('/product/new', name: 'product.create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        /**
         * Affiche le formulaire pour créer un nouveau produit.
         *
         * Cette méthode crée un formulaire basé sur ProductType,
         * gère la soumission et la validation des données. Si le formulaire
         * est valide, elle enregistre le nouveau produit dans la base
         * de données et redirige vers la liste des produits.
         *
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @param Request $request La requête HTTP contenant les données du formulaire.
         * @return Response La réponse HTTP contenant la vue du formulaire ou redirection.
         */

        // Création d'un nouvel objet Product
        $formData = new Product();
        // Création du formulaire de ProductType
        $form = $this->createForm(ProductType::class, $formData);
        // Récupération des données de la requête avec handleRequest
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Prépare l'entité pour être sauvegardée
            $em->persist($formData);
            // Envoie les données en BDD
            $em->flush();
            // Création d'un message de succès en session
            $this->addFlash("success", "product added successfully: " . $formData->getName());
            // Redirection vers la route product.index
            return $this->redirectToRoute('product.index');
        }

        // Retourne la vue pour afficher le formulaire
        return $this->render('product/new.html.twig', [
            // Envoie la variable form pour afficher le formulaire
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'product.show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        /**
         * Affiche les détails d'un produit spécifique.
         *
         * Cette méthode récupère le produit par son ID,
         * et renvoie la vue correspondante pour afficher
         * les informations du produit.
         *
         * @param Product $product L'objet produit récupéré par l'ID.
         * @return Response La réponse HTTP contenant la vue des détails du produit.
         */

        // Retourne la vue pour afficher les détails du produit
        return $this->render('product/show.html.twig', [
            'product' => $product, // Envoie le produit au template
        ]);
    }

    #[Route('/product/{id}/edit', name: 'product.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $em): Response
    {
        /**
         * Affiche le formulaire pour éditer un produit existant.
         *
         * Cette méthode crée un formulaire pré-rempli avec les données
         * du produit existant. Si le formulaire est soumis et valide,
         * elle enregistre les modifications et redirige vers la liste des produits.
         *
         * @param Request $request La requête HTTP contenant les données du formulaire.
         * @param Product $product L'objet produit à éditer.
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @return Response La réponse HTTP contenant la vue du formulaire ou redirection.
         */

        // Création du formulaire pour éditer le produit existant
        $form = $this->createForm(ProductType::class, $product);
        // Récupération des données de la requête avec handleRequest
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Applique les modifications à la base de données
                $em->flush();
                // Création d'un message de succès en session
                $this->addFlash("success", "product edited successfully: " . $product->getName());
                // Redirection vers la route product.index
                return $this->redirectToRoute('product.index');
            } catch (\Exception $e) {
                // En cas d'erreur, ajoute un message d'erreur en session
                $this->addFlash("error", "Product already exists");
            }
        }

        // Retourne la vue pour afficher le formulaire d'édition de produit
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(), // Envoie le formulaire au template
            'product' => $product, // Envoie le produit au template
        ]);
    }

    #[Route('/product/{id}/delete', name: 'product.remove', methods: ['GET'])]
    public function remove(Product $product, EntityManagerInterface $em): Response
    {
        /**
         * Supprime un produit de la base de données.
         *
         * Cette méthode supprime le produit spécifié,
         * enregistre les changements en base de données,
         * et redirige vers la liste des produits avec un message de succès.
         *
         * @param Product $product L'objet produit à supprimer.
         * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données.
         * @return Response La réponse HTTP redirigeant vers la liste des produits.
         */

        // Supprime le produit spécifié de la base de données
        $em->remove($product);
        // Applique les changements en base de données
        $em->flush();
        // Création d'un message de succès en session
        $this->addFlash("success", "product deleted successfully: " . $product->getName());
        // Redirection vers la route product.index
        return $this->redirectToRoute('product.index');
    }
}
