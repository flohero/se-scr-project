<?php


namespace Application\Queries;


use Application\Interfaces\ProductRepository;
use Application\ProductDTO;

class ProductsQuery {
    public function __construct(private ProductRepository $productRepository) {
    }

    public function execute(): array {
        $res = [];
        foreach ($this->productRepository->findAllProducts() as $product) {
            $res[] = new ProductDTO(
                $product->getId(),
                $product->getUserId(),
                $product->getName(),
                $product->getManifacturer(),
                $product->getDescription()
            );
        }
    }

}