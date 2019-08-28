<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ( $i = 0; $i<50; $i++)
        {
            $product = new Product();
            $product->setName('Nom du produit '.$i);
            $product->setDescription('Description du produit '.$i);
            $product->setPrice(rand(1000,1000000));
            $product->setHeart((bool)rand(0,1));
            $date = new DateTime('now');
            $product->setDate($date);
            $manager->persist($product);
        }

        for ( $i=0; $i<10; $i++)
        {
            $category = new Category();
            $category->setName('Gatégorie '.$i);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
