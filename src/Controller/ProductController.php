<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * @Route("/products/{page}", name="product_index", methods={"GET"}, requirements={"page"="\d+"})
     * 
     */
    public function list(ProductRepository $productRepository, CategoryRepository $categoryRepository, $page = 1): Response
    {
        $category = new Category();
        dump($category);
        
        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();

        $max_pages= ceil(count($products)/6);


        $debut = ($page -1 )*6;
        $fin = $debut+6;

        if ($page * 6 > count($products))
        {
            $fin = count($products);
        }

        for ($i = $debut; $i < $fin; $i++)
        {
            $product[] = $products[$i];
        }

        return $this->render('product/index.html.twig', [
            'products' => $product,
            'categories' => $categories,
            'current_page' => $page,
            'max_pages' => $max_pages,
        ]);
    }

    /**
     * @Route("admin/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, LoggerInterface $logger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $logger->info('New product "'.$product->getName().'"');

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/{slug}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("admin/products/edit/{id}", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LoggerInterface $logger, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($product != null)
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $logger->info('Edit product "'.$product->getName().'"');

                return $this->redirectToRoute('product_index');
            }
        }
        else
        {
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/products/delete/{id}", name="product_delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request, LoggerInterface $logger, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $logger->alert('Delete product "'.$product->getName().'"');
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
