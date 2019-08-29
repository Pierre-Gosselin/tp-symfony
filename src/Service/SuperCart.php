<?php



namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SuperCart
{
    private $session;


    /**
     * On récupère le service permettant de manipuler la session dans Symfony
     */

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Cette méthode permet d'ajouter un produit au panier
     */
    public function add($product)
    {
        // Récupérer les produits déjà présent en session
        $products = $this->session->get('productCart',[]);

        $products[] = [
            'quantity' => 1,
            'product' => $product,
        ];

        $this->session->set('productCart', $products);
    }

    /**
     * Calculer le total de tous les produits
     *
     */
    public function getSubtotal()
    {
        // Récupérer les produits
        $products = $this->session->get('productCart', []);
        $total = 0;

        // Parcourir les produits
        foreach ($products as $cartItem) {
            $total += $cartItem['product']->getPrice() * $cartItem['quantity'];
        }

        return $total;

    }

    public function count()
    {
        return count($this->session->get('productCart', []));
    }

    public function get()
    {
        return $this->session->get('productCart');
    }

    public function delete($product)
    {
        // Récupérer les produits déjà présents en session
        $products = $this->session->get('productCart', []);

        // Parcourir les produits
        foreach ($products as $key => $cartItem) {
            // Si on trouve le produit à supprimer dans le panier
            if ($cartItem['product']->getId() == $product->getId())
            {
                // On supprime le produit du tableau via sa clé numérique
                unset($products[$key]);
            }
        }

        // On met à jour la session
        $this->session->set('productCart', $products);
    }
}