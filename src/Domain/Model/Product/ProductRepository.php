<?php


namespace App\Domain\Model\Product;

interface ProductRepository
{
    public function create(Product $product);
    public function getProducts();
}
