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

    public function execute(): array {
        $res = [];
        foreach ($this->productRepository->findAllProducts() as $product) {
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