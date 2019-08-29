<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\SuperCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository, SuperCart $superCart)
    {
        
        // On récupère aléatoirement un produit aimé    
        $heartStrokeProduct = $productRepository->findOneByHeart(true);

        // On récupère les 4 derniers produits
        
        $lastProducts = $productRepository->findLastCreatedAt(4);

        $bestProducts = $productRepository->findBestProduct();

        $product = $productRepository->findProduct();

        return $this->render('home/index.html.twig', [
            'heartStrokeProduct' => $heartStrokeProduct,
            'lastProducts' => $lastProducts,
            'bestProducts' => $bestProducts,
            'products' => $product,
        ]);
    }

}
