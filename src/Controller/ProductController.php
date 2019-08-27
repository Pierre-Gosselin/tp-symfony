<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/", name="list")
     */
    public function list()
    {
        $products = [];
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/products/{slug}, name="show")
     */
    public function show($slug)
    {
        $products = [];
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
