<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session)
    {
        
        $products = $session->get('product');
        
        return $this->render('cart/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/cart/{slug}", name="putCart")
     */
    public function putCart(SessionInterface $session, $slug)
    {
        // ON ajoute le nom de l'URL dans la session
        $session->set('product', $slug);

        return $this->render('cart/index.html.twig');
    }
}
