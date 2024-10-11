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
    public function index(EntityManagerInterface $em,): Response
    {
        $datas=$em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'datas' => $datas,

        ]);
    }

    #[Route('/product/new', name: 'product.create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $formData = new Product();
        $form = $this->createForm(ProductType::class, $formData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($formData);
            $em->flush();
            $this->addFlash("success","product added successfully: ".$formData->getName());
            return $this->redirectToRoute('product.index');
        }
        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'product.show', methods: ['GET'])]
    public function show(Product $product, EntityManagerInterface $em): Response
    {
        $data=$em->getRepository(Product::class)->find($product->getId());

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'data'=>$data,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'product.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash("success","product edited successfully: ".$product->getName());
                return $this->redirectToRoute('product.index');
            }catch (\Exception $e){
                $this->addFlash("error","Product already exists");
            }

        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,

        ]);
    }

    #[Route('/product/{id}/delete', name: 'product.remove', methods: ['GET'])]
    public function remove(Product $product, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();
        $this->addFlash("success","product deleted successfully: ".$product->getName());
        return $this->redirectToRoute('product.index');

    }
}
