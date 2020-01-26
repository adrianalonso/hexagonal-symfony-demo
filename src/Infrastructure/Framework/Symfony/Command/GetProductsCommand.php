<?php

namespace App\Infrastructure\Framework\Symfony\Command;

use App\Application\Product\ListProductRequest;
use App\Application\Product\ListProductService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class GetProductsCommand
 * @package App\Infrastructure\Framework\Symfony\Command
 */
class GetProductsCommand extends Command
{
    protected static $defaultName = 'app:get-products';

    /**
     * @var ListProductService
     */
    private $listProductService;

    /**
     * GetProductsCommand constructor.
     * @param ListProductService $listProductService
     */
    public function __construct(ListProductService $listProductService)
    {
        $this->listProductService = $listProductService;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dto = new ListProductRequest();

        try {
            $data = $this->listProductService->handle($dto);
        } catch (\Exception $e) {
            $output->writeln("[ERROR] " . $e->getMessage());
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($data, 'json');

        return $output->writeln($jsonContent);
    }
}
