<?php


namespace Application\Queries;


use Application\DTOs\ProductDTO;
use Application\Interfaces\ProductRepository;

class ProductDetailsQuery {
    public function __construct(
        private ProductRepository $productRepository,
        private UserByIdQuery $userByIdQuery,
        private RatingCountPerProductQuery $ratingCountPerProductQuery,
        private AverageRatingScorePerProductQuery $averageRatingScorePerProductQuery
    ) {
    }

    public function execute(int $pid): ?ProductDTO {
        $product = $this->productRepository->findProductById($pid);
        $productDTO = null;
        if($product != null) {
            $userDTO = $this->userByIdQuery->execute($product->getUserId());
            $productDTO = new ProductDTO(
                $product->getId(),
                $userDTO,
                $product->getName(),
                $product->getManufacturer(),
                $product->getDescription(),
                $this->ratingCountPerProductQuery->execute($product->getId()),
                $this->averageRatingScorePerProductQuery->execute($product->getId())
            );
        }
        return $productDTO;
    }

}