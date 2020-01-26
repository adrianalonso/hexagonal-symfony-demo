<?php


namespace App\Tests\Application\Product;

use App\Application\Product\CreateProductRequest;
use App\Application\Product\CreateProductService;
use App\Domain\Model\Product\InvalidProductPriceException;
use App\Domain\Model\Product\ProductCreatedEvent;
use App\Infrastructure\Persistence\InMemory\InMemoryProductRepository;
use Doctrine\Common\EventSubscriber;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Zend\EventManager\ListenerAggregateInterface;

class CreateProductServiceTest extends KernelTestCase
{

    /**
     * @var CreateProductService
     */
    private $service;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    protected function setUp(): void
    {
        $repository = new InMemoryProductRepository();
        $this->eventDispatcher = new EventDispatcher();
        $this->service = new CreateProductService($repository, $this->eventDispatcher);
    }

    public function testCreateProduct()
    {
        $listener = new class() {
            protected $called = false;

            public function onProductCreatedEvent(ProductCreatedEvent $event)
            {
                $this->called = true;
            }

            public function isCalled(): bool
            {
                return $this->called;
            }
        };

        $this->eventDispatcher->addListener(ProductCreatedEvent::$EVENT_NAME, [$listener, 'onProductCreatedEvent']);

        $request = new CreateProductRequest("product test", 50);
        $productCreated = $this->service->handle($request);

        $this->assertEquals("product test", $productCreated->getName());
        $this->assertEquals(50, $productCreated->getPrice());
        $this->assertTrue($listener->isCalled());
    }

    public function testCreateProductWithInvalidPrice()
    {
        $this->expectException(InvalidProductPriceException::class);

        $request = new CreateProductRequest("product test", -5);
        $this->service->handle($request);
    }
}
