<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category")
     */
    public function show( Category $category, ProductRepository $productRepository): Response
    {
        $products = $category->getProducts();

        dump($products);

        foreach ($products as $product) {
            dump($product->getName());
        }

        $products = $productRepository->findByCategory($category->getId());
        dump($products);
        return $this->render('category/index.html.twig',[
            'products' => $products,
        ]);
    }
}
