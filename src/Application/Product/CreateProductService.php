<?php


namespace App\Application\Product;

use App\Application\ApplicationService;
use App\Domain\Model\Product\InvalidProductPriceException;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductCreatedEvent;
use App\Domain\Model\Product\ProductRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProductService implements ApplicationService
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

    public function handle(CreateProductRequest $request): Product
    {
        $product = new Product(null, $request->name(), $request->price());

        if ($product->getPrice() <= 0) {
            throw new InvalidProductPriceException("Invalid price received: " . $request->price());
        }

        $this->productRepository->create($product);

        $event = new ProductCreatedEvent($product);
        $this->eventDispatcher->dispatch($event, ProductCreatedEvent::$EVENT_NAME);

        return $product;
    }
}
