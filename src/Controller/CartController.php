<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\SuperCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SuperCart $superCart)
    {
        
        $productCart = $superCart->get('productCart');
        
        $prixTotal = $superCart->getSubtotal();

        return $this->render('cart/index.html.twig', [
            'productCart' => $productCart,
            'prixTotal' => $prixTotal,
        ]);
    }



    /**
     * @Route("/cart/delete/{id}", name="delete")
     */
    public function deleteCart(Product $product, SuperCart $superCart)
    {
        $superCart->delete($product);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function putCart(Product $product, SuperCart $superCart)
    {
        // ON ajoute le nom de l'URL dans la session
        $superCart->add($product);

        return $this->redirectToRoute('cart_index');
    }
}
