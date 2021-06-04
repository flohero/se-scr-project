<?php


namespace Application\Queries;


use Application\DTOs\UserDTO;
use Application\Interfaces\ProductRepository;
use Application\DTOs\ProductDTO;
use Application\Interfaces\UserRepository;

class ProductsQuery {
    public function __construct(
        private ProductRepository $productRepository,
        private UserByIdQuery $userByIdQuery
    ) {
    }

    public function execute(?int $cid): array {
        $res = [];
        if (!isset($cid)) {
            $products = $this->productRepository->findAllProducts();
        } else {
            $products = $this->productRepository->findAllProductsByCategory($cid);
        }
        foreach ($products as $product) {
            $userDTO = $this->userByIdQuery->execute($product->getUserId());
            $res[] = new ProductDTO(
                $product->getId(),
                $userDTO,
                $product->getName(),
                $product->getManufacturer(),
                $product->getDescription()
            );
        }
        return $res;
    }

}