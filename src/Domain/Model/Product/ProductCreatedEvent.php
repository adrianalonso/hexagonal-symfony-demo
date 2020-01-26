<?php


namespace App\Domain\Model\Product;

class ProductCreatedEvent
{
    public static $EVENT_NAME = "product:created";

    protected $product;

    /**
     * ProductCreatedEvent constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
