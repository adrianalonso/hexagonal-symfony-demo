<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;

class InMemoryProductRepository implements ProductRepository
{

    /**
     * @var ArrayCollection
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();

        $this->products->add(new Product(1, "Producto 1", 40));
        $this->products->add(new Product(2, "Producto 2", 23));
    }

    public function create(Product $product)
    {
        $this->products->add($product);
    }

    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }
}
