<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product;
        $product->setName('P1');
        $product->setDescription('Ergonomic and stylish! P1');
        $product->setSize(100);
        $manager->persist($product);

        $product = new Product;
        $product->setName('P2');
        $product->setDescription('Ergonomic and stylish! P2');
        $product->setSize(200);
        $manager->persist($product);

        $manager->flush();
    }
}
