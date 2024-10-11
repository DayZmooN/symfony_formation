<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Xml\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RecipeController extends AbstractController
{
//    #[Route('/demo', name: 'demo')]
//    public function demo(ValidatorInterface $validator){
//        $recipe = new Recipe();
//        $error=$validator->validate($recipe);
//        dd($validator,$error);
//
//    }
    #[Route('/recettes', name: 'recette.index')]
    public function index(Request $request,RecipeRepository $repository,EntityManagerInterface $em): Response
    {

     $recipes=$repository->findWithDurationLowerThan(100);


        //dd($repository->findTotalDuration($recipes));
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recettes/{slug}-{id}', name: 'recette.show', requirements: ['id' => '\d+', 'slug' => '[a-zA-Z0-9À-ÿ-]+'])]
    public function recettePateBolognaise(Request $request,string $slug, int $id,RecipeRepository $recipeRepositoryId): Response
    {
       $recipeId=$recipeRepositoryId->find($id);

       if($recipeId->getSlug() !== $slug){
           return $this->redirectToRoute('recette.show',['slug'=>$recipeId->getSlug(),'id'=>$recipeId->getId()]);
       }
        return $this->render('recipe/show.html.twig',[
            'recipe' => $recipeId,
        ]);
    }

    #[Route('/recettes/{id}/edit',name:'recette.edit',requirements: ['id'=>'\d+'],methods: ['GET','POST'])]
    public function edit(Request $request,EntityManagerInterface $em,Recipe $recipe): Response
    {
        $form= $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if($request->isMethod('POST')&&$form->isValid()){
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success','la recette a ben été modfiée');
            return $this->redirectToRoute('recette.index');
        }
        return $this->render('recipe/edit.html.twig',[
            'form'=>$form->createView(),
            'recipe'=>$recipe,
        ]);
    }

    #[Route('/recettes/create',name:'recette.create')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        //cree une instance de objet Recipe
        $recipe= new Recipe();


        //création du formulaire pour l'objet Recipe
        $form = $this->createForm(RecipeType::class, $recipe);

        //on recupere les données du formulare dans la requete
        $form->handleRequest($request);

        // on verfie si le formulaire a etait soumis
        if ( $form->isSubmitted()&&$form->isValid() ) {
            //On Définit la date de création à la date actuelle
//            $recipe->setCreatedAt(new \DateTimeImmutable());
//            $recipe->setUpdatedAt(new \DateTimeImmutable());
            // on persiste c'est a dire qu'on preparer les donner a envoyer
            $em->persist($recipe);
            //Engrestrie les modifications dans la base de donées
            $em->flush();
            //message cree en session
            $this->addFlash('success','la recette a bien etait crée');
            //on renvoi sur la route
            return $this->redirectToRoute('recette.index');
        }

        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/recettes/{id}/delete',name:'recette.delete')]
    public function delete(Request $request,EntityManagerInterface $em,int $id): Response
    {

        //recupére id en bdd avec d qui id qui et transmis lors de la requette
        $recipe = $em->getRepository(Recipe::class)->find($id);

        //  Gestion erreur  verifie si recipe et null
        if ($recipe === null) {
            // Crée un message en session
            $this->addFlash('danger', 'La recette n\'existe pas');
            // Renvoie sur la route
            return $this->redirectToRoute('recette.index');
        }

        //utlise la methode remove
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success','la recette a etait supprimer');
        return $this->redirectToRoute('recette.index');
    }

}
