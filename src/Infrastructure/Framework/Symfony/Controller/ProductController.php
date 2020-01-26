<?php

namespace App\Infrastructure\Framework\Symfony\Controller;

use App\Application\Product\CreateProductRequest;
use App\Application\Product\CreateProductService;
use App\Application\Product\ListProductRequest;
use App\Application\Product\ListProductService;
use App\Domain\Model\Product\InvalidProductPriceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ProductController
 * @package App\Infrastructure\Framework\Symfony\Controller
 */
class ProductController extends AbstractController
{

    /**
     * @param CreateProductService $service
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(CreateProductService $service, Request $request)
    {
        $dto = new CreateProductRequest(
            $request->get("name"),
            $request->get("price")
        );

        try {
            $service->handle($dto);
        } catch (InvalidProductPriceException $e) {
            return new JsonResponse(['result' => "KO", 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['result' => "KO", 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['result' => "OK"]);
    }

    /**
     * @param ListProductService $service
     * @param Request $request
     * @return JsonResponse
     */
    public function listProducts(ListProductService $service, Request $request)
    {
        $dto = new ListProductRequest();

        try {
            $data = $service->handle($dto);
        } catch (\Exception $e) {
            return new JsonResponse(['result' => "KO", 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return new JsonResponse([
            'result' => "OK",
            'data' => json_decode($this->serialize($data))
        ]);
    }
}
