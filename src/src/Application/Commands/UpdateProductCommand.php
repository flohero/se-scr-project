<?php


namespace Application\Commands;


use Application\Interfaces\ProductRepository;

class UpdateProductCommand {
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }


    public function execute(int $pid, int $category, string $name, string $manufacturer, string $content): bool {
        return $this->productRepository->updateProduct($pid, $category, $name, $manufacturer, $content);
    }
}