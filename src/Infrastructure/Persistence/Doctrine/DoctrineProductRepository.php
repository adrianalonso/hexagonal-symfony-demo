<?php


namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProducts()
    {
        return $this->createQueryBuilder('p')->getQuery()->execute();
    }

    public function create(Product $product)
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }
}
