<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;

final class ProductController extends AbstractController
{
    #[Route('/products ', name: 'product_index')]
    public function index(ProductRepository $repository): Response
    {
        // $products = $repository->findAll();
        // dump($products);
        // dd($products);

        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll(),
        ]);
    }

    #[Route('/products/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('notice', 'Product created!');

            return $this->redirectToRoute('product_show',[
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/new.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/products/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('notice', 'Product updated!');

            return $this->redirectToRoute('product_show',[
                'notice', 'Product updated!'
            ]);
        }

        return $this->render('product/edit.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/products/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Request $request, Product $product, EntityManagerInterface $manager): Response {

        if ($request->isMethod('POST')) {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash('notice', 'Product deleted!');

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/delete.html.twig',[
            'id' => $product->getId(),
            'name' => $product->getName(),
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }

    // public function show($id,ProductRepository $repository): Response
    // {
    //     $product = $repository->findOneBy(['id' => $id]);

    //     if (!$product) {
    //         throw $this->createNotFoundException(
    //             'No product found for id '.$id
    //         );
    //     }

    //     return $this->render('product/show.html.twig',[
    //         'product' => $product
    //     ]);
    // }
}
