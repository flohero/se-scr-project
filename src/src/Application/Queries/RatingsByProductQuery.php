<?php


namespace Application\Queries;


use Application\DTOs\RatingDTO;
use Application\Interfaces\RatingRepository;

class RatingsByProductQuery {
    public function __construct(
        private RatingRepository $ratingRepository,
        private ProductDetailsQuery $productDetailsQuery,
        private UserByIdQuery $userByIdQuery
    ) {
    }

    public function execute(int $rid): array {
        $ratings = $this->ratingRepository->findRatingsByProduct($rid);
        $ratingDTOs = [];
        foreach ($ratings as $rating) {
            $ratingDTOs[] = new RatingDTO(
                $rating->getId(),
                $this->productDetailsQuery->execute($rating->getProductId()),
                $this->userByIdQuery->execute($rating->getUserId()),
                $rating->getScore(),
                $rating->getCreated(),
                $rating->getTitle(),
                $rating->getContent()
            );
        }
        return $ratingDTOs;
    }
}