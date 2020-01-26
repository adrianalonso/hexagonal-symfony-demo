<?php


namespace App\Domain\Model\Product;

class Product
{
    protected $id;
    protected $name;
    protected $price;

    /**
     * Product constructor.
     * @param $name
     * @param $price
     */
    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function toArray()
    {
        return [
            'name'=> $this->name,
            'price'=>$this->price,
        ];
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
