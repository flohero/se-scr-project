<?php


namespace Application\Queries;


use Application\DTOs\RatingDTO;
use Application\Interfaces\RatingRepository;

class RatingByUserAndProductQuery {
    public function __construct(
        private RatingRepository $ratingRepository,
        private ProductDetailsQuery $productDetailsQuery,
        private UserByIdQuery $userByIdQuery
    ) {
    }

    public function execute(int $userId, int $pid): ?RatingDTO {
        $rating = $this->ratingRepository->findRatingByUserAndProduct($userId, $pid);
        $ratingDTO = null;
        if (isset($rating)) {
            $ratingDTO = new RatingDTO(
                $rating->getId(),
                $this->productDetailsQuery->execute($rating->getProductId()),
                $this->userByIdQuery->execute($userId),
                $rating->getScore(),
                $rating->getCreated(),
                $rating->getTitle(),
                $rating->getContent()
            );
        }
        return $ratingDTO;
    }

}