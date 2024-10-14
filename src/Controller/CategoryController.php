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
        $datas =$em->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'datas' => $datas
        ]);
    }


    #[Route('/category/create',name: 'category.create')]
    public function new(EntityManagerInterface $em,Request $request): Response
    {
        $form=$this->createForm(CategoryType::class);
        $formData = $form->handleRequest($request);

        if($formData->isSubmitted()&& $formData->isValid()){
            $em->persist($formData->getData());
            $em->flush();

            $this->addFlash('success','category created');
            return $this->redirectToRoute('category.index');
        }

        return $this->render('category/new.html.twig', [
            'form'=>$form,
            ]);
    }

    #[Route('/category/{id}',name: 'category.show')]
    public function show(Category $category,EntityManagerInterface $em): Response
    {
        $category=$em->getRepository(Category::class)->find($category->getId());

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
    #[Route('/category/{id}/remove',name: 'category.remove')]
    public function remove(EntityManagerInterface $em,Category $category): Response
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success','category removed');
        return $this->redirectToRoute('category.index');

    }

    #[Route('/category/{id}/edit',name: 'category.edit')]
    public function edit(EntityManagerInterface $em,Category $category,Request $request): Response {

        $form=$this->createForm(CategoryType::class,$category);
        $formData =$form->handleRequest($request);
        if($request->isMethod('POST')&&$formData->isSubmitted()&& $formData->isValid()){
            try {
                $em->flush();
                $this->addFlash('success','category updated');
                return $this->redirectToRoute('category.index');
            }catch(\Exception $e){
                $this->addFlash('error',$e->getMessage());
            }

        }


        return $this->render('category/edit.html.twig', [
            'form'=>$form,
            'category' => $category,

        ]);
    }
}
