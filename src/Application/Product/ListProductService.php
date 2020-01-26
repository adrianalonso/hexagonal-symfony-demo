<?php


namespace App\Application\Product;

use App\Application\ApplicationService;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductCreatedEvent;
use App\Domain\Model\Product\ProductRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ListProductService implements ApplicationService
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        ProductRepository $productRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->productRepository = $productRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(ListProductRequest $request)
    {
        return $this->productRepository->getProducts();
    }
}
