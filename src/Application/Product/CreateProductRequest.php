<?php


namespace App\Application\Product;

class CreateProductRequest
{
    protected $name;
    protected $price;

    /**
     * CreateProductRequest constructor.
     * @param $name
     * @param $price
     */
    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     *
     */
    public function price(): int
    {
        return $this->price;
    }
}
