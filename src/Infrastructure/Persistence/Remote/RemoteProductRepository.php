<?php

namespace App\Infrastructure\Persistence\Remote;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RemoteProductRepository implements ProductRepository
{

    /**
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $endpoint;

    public function __construct()
    {
        $this->client = HttpClient::create();
        $this->endpoint = "https://5e2c84291b72860014dd5499.mockapi.io/api/v1/product";
    }


    public function create(Product $product)
    {
        try {
            $response = $this->client->request(Request::METHOD_POST, $this->endpoint, [
                'json' => $product->toArray(),
            ]);
        } catch (TransportExceptionInterface $e) {
            throw new RemoteException($e->getMessage());
        }

        if ($response->getStatusCode() !== Response::HTTP_CREATED) {
            throw new RemoteException("Remote exception on create product ");
        }

        $data = json_decode($response->getContent());

        $product->setId($data['id']);

        return $product;
    }

    public function getProducts(): ArrayCollection
    {
        try {
            $result = $this->client->request(Request::METHOD_GET, $this->endpoint);
        } catch (TransportExceptionInterface $e) {
            throw new RemoteException($e->getMessage());
        }

        $data = json_decode($result->getContent(), true);

        $result = new ArrayCollection();

        foreach ($data as $row) {
            $result->add(new Product($row['id'], $row['name'], $row['price']));
        }

        return $result;
    }
}
