<?php


namespace Application\Queries;


use Application\Interfaces\ProductRepository;
use Application\DTOs\ProductDTO;

class ProductsQuery {
    public function __construct(
        private ProductRepository $productRepository,
        private UserByIdQuery $userByIdQuery,
        private RatingCountPerProductQuery $ratingCountPerProductQuery,
        private AverageRatingScorePerProductQuery $averageRatingScorePerProductQuery
    ) {
    }

    public function execute(?int $cid, ?string $search): array {
        $res = [];
        if (!isset($cid)) {
            $products = $this->productRepository->findAllProductsByName($search);
        } else {
            $products = $this->productRepository->findAllProductsByCategoryAndName($cid, $search);
        }
        foreach ($products as $product) {
            $userDTO = $this->userByIdQuery->execute($product->getUserId());
            $res[] = new ProductDTO(
                $product->getId(),
                $userDTO,
                $product->getName(),
                $product->getManufacturer(),
                $product->getDescription(),
                $this->ratingCountPerProductQuery->execute($product->getId()),
                $this->averageRatingScorePerProductQuery->execute($product->getId())
            );
        }
        return $res;
    }

}