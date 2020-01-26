<?php

namespace App\Infrastructure\Framework\Symfony\Controller;

use App\Application\Product\CreateProductRequest;
use App\Application\Product\CreateProductService;
use App\Application\Product\ListProductRequest;
use App\Application\Product\ListProductService;
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
abstract class AbstractController
{
    protected function serialize($data)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        return  $serializer->serialize($data, 'json');
    }
}
